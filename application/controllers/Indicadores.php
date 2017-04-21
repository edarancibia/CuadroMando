<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Indicadores_model');
		$this->load->model('IndicadorInforme');
		$this->load->model('Caracteristicas');
		$this->load->model('Ambitos');
		$this->load->model('Unidades_model');
		$this->load->model('Cargos_model');
		$this->load->library('Pdf');
	}

	public function index(){
		/*$idCarac = $_GET['idCarac'];
		$data['caracteristicas'] = $this->Caracteristicas->getById($idCarac);
		$data['indicadores'] = $this->Indicadores_model->getByCaracteristica($idCarac);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('indicadores/datosIndicador',$data);*/
		//$this->getIndicaCargo();
		//$this->load->view('testpdf');
	}

	public function redirectCarateristica(){
		$caract = $_GET['idCarac'];
		echo($caract);
	}

	public function template(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
	}

	public function templateSupervisor(){
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
	}	

	//LISTA INDICADORES POR USUARIO RESPONSABLE

	//metodo llamado desde menu MIS INDICADORES para mantenerse en la misma vista en caso de no haber informacion para el informe
	public function misIndicadores2(){
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];
		$data['indica'] = $this->Indicadores_model->getByCargoYunidad($rut,$idUnidad);
		//$data['unidad'] = $idUnidad;
		
		if ($this->session->userdata('cargo') == 1) {
			$this->templateSupervisor();
			$this->load->view('indicadores/IndicadoresCargo',$data);
		}else{
			$this->template();
			$this->load->view('indicadores/IndicadoresCargo',$data);
		}
	}

	//metodo que busca Los indicadores asisgnados por unidad y usuario
	public function MisIndicadores(){
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];
		$data['unidad'] = $idUnidad;
		$data['indica'] = $this->Indicadores_model->getByCargoYunidad($rut,$idUnidad);

		$this->template();
		$this->load->view('indicadores/IndicadoresCargo',$data);
	}

	//MUESTRA DETALLE DEL INDICADOR SELCCIONADO Y PERMITE INGRESAR VALORES
	public function detalleIndicador(){
		$idIndicador = $_GET['idIndicador'];
		$idUnidad = $_REQUEST['idUnidad'];
		$data['indicador'] = $this->Indicadores_model->getById($idIndicador);
		$data['unidad'] = $idUnidad;
		
		if ($this->session->userdata('cargo') == 1) {
			$this->templateSupervisor();
			$this->load->view('indicadores/datosIndicador',$data);
		}else{
			$this->template();
			$this->load->view('indicadores/datosIndicador',$data);
		}
	}

	//GUARDA LOS VALORES MENSUAlES POR INDICADOR
	public function guardaEvaluacion(){
		$denominador = $this->input->post('denominador');
		$numerador = $this->input->post('numerador');
		$multiplicador = $this->input->post('multiplicador');
		$resultado = $this->input->post('resultado');
		$idIndicador = $this->input->post('idIndicador');
		$fecha = $this->input->post('fecha');
		$periodo = $this->input->post('periodo');
		$this->Indicadores_model->insertEvaluacion($denominador,$numerador,$multiplicador,$resultado,$idIndicador,$fecha,$periodo);
	}

	public function getUltima(){
		$idIndicador = $_POST['idIndicador'];

		if ($this->Indicadores_model->getUltimaEvaluacion($idIndicador) != null) {
			$fechaUlt = $this->Indicadores_model->getUltimaEvaluacion($idIndicador);
			echo $fechaUlt->fecha;
		}else{
			echo 0; //solo si nunca se evaluado este indicador
		}
	}

	//- - - Valida que solo grabe 1 x mes
	public function validateDate(){  
		$idIndicador = $_POST['idIndicador'];
		print_r($this->Indicadores_model->validaFecha($idIndicador));
	}

	//OBTIENE NOMBRE DEL AMBITO SELECCIONADO
	public function NombreAmbito($idAmbito){
		$amb = $this->Ambitos->getById($idAmbito);
		$nomAmbito = $amb->descripcion;
		return $nomAmbito;
	}

	//cargar vista index con buscador de datos por trimestre y ambito
	public function VistaAmbitos2(){
		$idAmbito =  $_GET['idAmbito'];
		$data['idAmbito'] = $idAmbito;
		$data['ambito'] = $this->NombreAmbito($idAmbito);
		$this->templateSupervisor();
		$this->load->view('supervisor/listaIndicadores',$data);
	}

	//- - -  - Muestra lista de indicadores segun ambito seleccionado - - - - 
	public function VistaAmbitos(){
		$idAmbito = $this->input->post('idAmbito',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$fecha = getdate();
		$anio = $fecha['year'];
		$data['indicadoresAmbito']= $this->Indicadores_model->getByAmbito($idAmbito,$anio,$trimestre);
		$data['ambito'] = $this->NombreAmbito($idAmbito);
		
		if ($this->session->userdata('cargo') == 1) {
			$this->templateSupervisor();
			$this->load->view('supervisor/listaIndicadores',$data);
		}else{
			$this->template();
			$this->load->view('supervisor/listaIndicadores',$data);
		}
	}

	//cargar vista index con buscador de datos por trimestre y unidad
	public function ResultIndex(){
		$idUnidad = $_GET['idUnidad'];
		$data['idUnidad'] = $idUnidad;
		$data['unidad'] = $this->NombreUnidad($idUnidad);
		$this->templateSupervisor();
		$this->load->view('supervisor/listaIndicadores2', $data);
	}


	//- - -  - Muestra lista de indicadores segun la unidad seleccionada - - - - 
	public function Result(){
		$idUnidad = $this->input->post('idUnidad',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$fecha = getdate();
		$anio = $fecha['year'];
		$data['indicadoresUnidad'] = $this->Indicadores_model->getByUnidad($idUnidad,$anio,$trimestre);
		$data['unidad'] = $this->NombreUnidad($idUnidad);
		
		if ($this->session->userdata('cargo') == 1) {
			$this->templateSupervisor();
			$this->load->view('supervisor/listaIndicadores2',$data);
		}else{
			$this->template();
			$this->load->view('supervisor/listaIndicadores2',$data);
		}
	}

	//OBTIENE NOMBRE DE LA UNIDAD SELCCIONADA
	public function NombreUnidad($idUnidad){
		$uni = $this->Ambitos->getByUnidadId($idUnidad);
		$nomUnidad = $uni->descripcion;
		return $nomUnidad;
	}

	//OBTIENE DATOS DEL RESPONSABLE DEL INDICADOR PARA ENVIAR EMAIL
	public function Responsable(){
		$idIndicador = $_REQUEST['idIndicador'];
		$data['resp'] = $this->Indicadores_model->getDatosResponsable($idIndicador);
		echo json_encode($data);
	}

	//GUARDA NUEVO INDICADOR EN MODULO DE ADMINISTRACION
	public function nuevo(){
		$umbral = $this->input->post('umbral');
		$idCarac = $this->input->post('caract');
		$descripcion = $this->input->post('desc');
		$f1 = $this->input->post('f1');
		$f2 = $this->input->post('f2');
		$umbralDesc = $this->input->post('umbralDesc');
		$subUn = $this->input->post('subUn');

		return $this->Indicadores_model->insert($subUn,$descripcion,$umbral,$f1,$f2,$umbralDesc,$idCarac);
	}

	//carga formulario de mantencion de indicadores
	public function Mantencion(){
		$data['unidades'] = $this->Unidades_model->getAll();
		$data['cargos'] = $this->Cargos_model->getAll();
		$this->templateSupervisor();
		$this->load->view('supervisor/mantencion',$data);
	}

	//autocompletar caracteriscita en modulo de mantencion de indicadores
	public function getCaracteristica(){
		if (isset($_GET['term'])) {
			$q = $_GET['term'];
			echo $this->Caracteristicas->get_Caracteristica($q);
		}
	}

	//guarda relacion entre indicador-unidad
	public function relIndUnidad(){
		$idIndicador = $this->input->post('idIndicador');
		$idUnidad = $this->input->post('idUnidad');
		$this->Indicadores_model->relIndUni($idIndicador,$idUnidad);
	}

	//guarda relacion entre indicador-cargo
	public function relIndCar(){
		$idIndicador = $this->input->post('idIndicador');
		$idCargo = $this->input->post('idCargo');
		$this->Indicadores_model->relIndCargo($idIndicador,$idCargo);
	}
}






