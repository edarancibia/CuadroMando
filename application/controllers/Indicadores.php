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
		$this->load->model('Login_model');
		$this->load->library('Pdf');
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
			$this->load->view('indicadores/indicadoresCargo',$data);
		}else{
			$this->template();
			$this->load->view('indicadores/indicadoresCargo',$data);
		}
	}

	//metodo que busca Los indicadores asisgnados por unidad y usuario
	public function MisIndicadores(){
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];
		$data['unidad'] = $idUnidad;
		$data['indica'] = $this->Indicadores_model->getByCargoYunidad($rut,$idUnidad);
		$data['nomUnidad'] = $this->NombreUnidad($idUnidad);

		$this->template();
		$this->load->view('indicadores/indicadoresCargo',$data);
	}

	//llena listado de indicadores por cargo,unidad y subdivision
	public function MisIndicadores3(){
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];
		$subd = $_REQUEST['subdivision'];
		$data['unidad'] = $idUnidad;
		$data['indica'] = $this->Indicadores_model->getByCargoUnidadYsubd($rut,$idUnidad,$subd);
		$data['nomUnidad'] = $this->NombreUnidad($idUnidad);

		$this->template();
		$this->load->view('indicadores/indicadoresCargo',$data);
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
		$periodo = $this->input->post('periodo');
		print_r($this->Indicadores_model->validaFecha($idIndicador,$periodo));
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

	//DEFINE EL RANGO DE BUSQUEDA DE DATOS SEGUN AÑO Y EL CAMPO PERIODO
	public function rango($trimestre,$anio){
		switch ($trimestre) {
			case 1:
				$desde = $anio.'1';
				$hasta = $anio.'3';
				break;
			case 2:
				$desde = $anio.'4';
				$hasta = $anio.'6';
				break;
			case 3:
				$desde = $anio.'7';
				$hasta = $anio.'9';
				break;
			case 4:
				$desde = $anio.'10';
				$hasta = $anio.'12';
				break;
			default:
				# code...
				break;
		}
		return array($desde,$hasta);
	}

	//- - -  - Muestra lista de indicadores segun ambito seleccionado - - - - 
	public function VistaAmbitos(){
		$idAmbito = $this->input->post('idAmbito',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$fecha = getdate();
		$anio = $this->input->post('cboanio4');
		$desde;
		$hasta;

		list($desde,$hasta) = $this->rango($trimestre,$anio);
		$data['indicadoresAmbito']= $this->Indicadores_model->getByAmbito($idAmbito,$anio,$desde,$hasta);
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

	//carga vista con medidicones de la unidad del usuario
	public function Mediciones(){
		$idUnidad = $_GET['idUnidad'];
		$data['idUnidad'] = $idUnidad;
		$data['unidad'] = $this->NombreUnidad($idUnidad);
		$this->template();
		$this->load->view('indicadores/mediciones', $data);
	}


	//- - -  - Muestra lista de indicadores segun la unidad seleccionada - - - - 
	public function Result(){
		$idUnidad = $this->input->post('idUnidad',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$fecha = getdate();
		$anio = $this->input->post('cboanio5');
		$desde;
		$hasta;

		list($desde,$hasta) = $this->rango($trimestre,$anio);
		$data['indicadoresUnidad'] = $this->Indicadores_model->getByUnidad($idUnidad,$anio,$desde,$hasta);
		$data['unidad'] = $this->NombreUnidad($idUnidad);
		
		if ($this->session->userdata('cargo') == 1) {
			$this->templateSupervisor();
			$this->load->view('supervisor/listaIndicadores2',$data);
		}else{
			$this->template();
			$this->load->view('supervisor/listaIndicadores2',$data);
		}
	}

	//llama vista que busca resultados de indicadores de seccion del usuario
	public function MiUnidad(){
		$idUnidad = $_GET['idUnidad'];
		$this->template();
		$this->load->view('indicadores/mediciones');
	}

	//- - -  - Muestra lista de resultados de indicadores de la unidad del usuario - - - - 
	public function ResultMediciones(){
		$idUnidad = $this->input->post('idUnidad',TRUE);
		$trimestre = $this->input->post('trimestre',TRUE);
		$fecha = getdate();
		$anio = $this->input->post('cboanio5');
		$desde;
		$hasta;

		list($desde,$hasta) = $this->rango($trimestre,$anio);
		$data['indicadoresUnidad'] = $this->Indicadores_model->getByUnidad($idUnidad,$anio,$desde,$hasta);
		$data['unidad'] = $this->NombreUnidad($idUnidad);
		
		$this->template();
		$this->load->view('indicadores/mediciones',$data);
	}

	//llama vista mis Unidades
	public function MisUnidades(){
		$rut = $this->session->userdata('rut');
		$idCargo = $this->Login_model->getCargo2($rut);
		$idCargo2 = $idCargo->idCargo;
		$data['unidades'] = $this->Unidades_model->getUnidades($idCargo2);
		$this->template();
		$this->load->view('encargado/misUnidades',$data);
	}

	//calcula en cuarto(trimestre) actual
	public function quarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}

	public function getAnio(){
		$fecha = getdate();
		$anio = $fecha['year'];
		return $anio;
	}

	//carga vista de preview de indicadores 
	public function Preview(){
		$anio = $this->getAnio();
		$cuarto = $this->quarter();
		$desde;
		$hasta;

		list($desde,$hasta) = $this->rango($cuarto,$anio);
		$data['info'] = $this->Indicadores_model->getPreview($anio,$desde,$hasta);
		$this->templateSupervisor();
		$this->load->view('supervisor/preview',$data);
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

		echo $this->Indicadores_model->insert($subUn,$descripcion,$umbral,$f1,$f2,$umbralDesc,$idCarac);
	}

	//carga formulario de mantencion de indicadores
	public function Mantencion(){
		$data['unidades'] = $this->Unidades_model->getAll();
		$data['cargos'] = $this->Cargos_model->getAll();
		$this->templateSupervisor();
		$this->load->view('supervisor/mantencion',$data);
	}

	public function MantencionCargos(){
		$data['cargos'] = $this->Cargos_model->getAll();
		$data['unidades'] = $this->Unidades_model->getAll();
		$this->templateSupervisor();
		$this->load->view('supervisor/mantencionCargos',$data);
	}

	public function ListaPorUnidad(){
		header('Content-Type: application/json');
		$idUnidad = $this->input->post('idUnidad');
		$data['indicadores'] = $this->Indicadores_model->getIndicadoresMan($idUnidad);
		echo json_encode($data);
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

	//llama vista para modificar datos de evaluaciones de indicadores
	public function EditIndex2(){
		$idIndicador = $_REQUEST['txtidndicador'];
		$mes = $_REQUEST['cbomes2'];
		$anio = $_REQUEST['cboanio7'];
		//$idUnidad = $_REQUEST['idUnidad'];
		$periodo = $anio.$mes;

		$data['info'] = $this->Indicadores_model->getDataIndicador($idIndicador,$periodo);
		//echo json_encode($data);
		if (empty($data['info'])) {
			echo "<script>alert('no hay datos')
					history.go(-1);</script>";
		}else{
			$this->templateSupervisor();
			$this->load->view('supervisor/editaDatos',$data);
		}
	}

	//llama vista index de lista de indicadores para editar datos mensuales
	public function EditIndex(){
		$data['unidades'] = $this->Unidades_model->getAll();
		$this->templateSupervisor();
		$this->load->view('supervisor/editaIndex',$data);
	}

	//LLENA LISTA DE INDICADORES POR SECCION PARA EDITAR DATOS
	public function EditList(){
		$idUnidad = $this->input->post('idUnidad');
		$data['lista'] = $this->Indicadores_model->Lista($idUnidad);
		echo json_encode($data);
	}

	//lista de indicadores para editar sus datos mensuales
	public function EditResult(){
		$idUnidad = $this->input->post('idUnidad');
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		//$idUnidad = $_REQUEST['idUnidad'];
		$data['lista'] = $this->Indicadores_model->Lista($idUnidad);
		echo json_encode($data);
	}

	//modificadatos del indicador seleccionado y su periodo
	public function Edit(){
		$idIndicador = $_REQUEST['idIndicador'];
		$periodo = $_REQUEST['periodo'];
		$numerador = $this->input->post('denominador'); //aqui denominador de num erador estan invertidos
		$denominador = $this->input->post('numerador');
		$this->Indicadores_model->editaDatos($idIndicador,$periodo,$numerador,$denominador);
	}

	//llama vista index de lista de indicadores para editar datos mensuales
	public function editIndicador(){
		$data['unidadesUmbral'] = $this->Unidades_model->getAll();
		$this->templateSupervisor();
		$this->load->view('supervisor/editIndicador',$data);
	}

	//obtiene umbral
	public function GetUmbral(){
		$idIndicador = $this->input->post('idIndicador');
		$data['umbral'] = $this->Indicadores_model->getUmbral($idIndicador);
		echo json_encode($data);
	}

	//actualiza umbral
	public function UpdateUmbral(){
		$idIndicador = $this->input->post('idIndicador');
		$umbral = $this->input->post('umbral');
		$umbralDesc = $this->input->post('umbralDesc');
		$this->Indicadores_model->updUmbral($idIndicador,$umbral,$umbralDesc);
	}

}






