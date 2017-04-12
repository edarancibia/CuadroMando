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
		$data['indicadoresAmbito']= $this->Indicadores_model->getByAmbito($idAmbito,$trimestre);
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


	//- - -  - Muestra lista de indicadores segun la unidad selccionada - - - - 
	public function Result(){
		$idUnidad = $this->input->post('idUnidad',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$data['indicadoresUnidad'] = $this->Indicadores_model->getByUnidad($idUnidad,$trimestre);
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



}






