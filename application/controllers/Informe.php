<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informe extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('IndicadorInforme');
		$this->load->model('Caracteristicas');
		$this->load->model('Indicadores_model');
		$this->load->model('Unidades_model');	
		$this->load->library('Pdf');	
	}

	public function cabecera(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
	}

	public function trimestre($mes=null){
	  	$mes = is_null($mes) ? date('m') : $mes;
	  	$trim=floor(($mes-1) / 3)+1;
	  	return $trim;
	}

	public function periodo(){
		$idIndicador = $_REQUEST['idIndicador'];
		$data['indicador'] = $this->Indicadores_model->getById($idIndicador);
		$this->cabecera();
		$this->load->view('informes/periodo',$data);
	}

	//define los parametros de busqueda de datos de informe(periodo desde hasta)
	public function desdeHasta($cuarto,$anio){

		if ($cuarto == 1) {
			$m1 = 1;
			$m2 = 2;
			$m3 = 3;

			$desde = $anio.$m1;
			$hasta = $anio.$m3;
			return array($desde,$hasta);
		}

		if ($cuarto == 2) {
			$m1 = 4;
			$m2 = 5;
			$m3 = 6;
			$desde = $anio.$m1;
			$hasta = $anio.$m3;
			return array($desde,$hasta);
		}

		if ($cuarto == 3) {
			$m1 = 7;
			$m2 = 8;
			$m3 = 9;
			$desde = $anio.$m1;
			$hasta = $anio.$m3;
			return array($desde,$hasta);
		}

		if ($cuarto == 4) {
			$m1 = 10;
			$m2 = 11;
			$m3 = 12;
			$desde = $anio.$m1;
			$hasta = $anio.$m3;
			return array($desde,$hasta);
		}
	}

	//metodo llamado desde el boton INFORME en menu MIS INDICADORES
	public function Informe(){
		$idIndicador = $_REQUEST['idIndicador'];
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];
		$cuarto = $this->input->post('cboCuarto');
		$anio = $this->input->post('cboAnio3');
		$periodo = $cuarto.$anio;
		$desde;
		$hasta;
		$m1;
		$m2;
		$m3;

		list($desde,$hasta) = $this->desdeHasta($cuarto,$anio);


		$trimestre = $this->trimestre();

		//pregunta si hay datos de evaluaciones en en trimestre para realizar el informe
		if ($this->IndicadorInforme->existenDatos($idIndicador,$anio,$desde,$hasta) == true) {
		
			if ($this->IndicadorInforme->existeInforme($idIndicador,$periodo) == true) {//pregunta si hay informe hecho este trimestre
				//hay informacion y el informe esta hecho
				$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
				$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
				//$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYrut($idIndicador,1);
				$data['datos1'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
				$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYPerido($idIndicador,$desde,$hasta);
				$data['indicador'] = $idIndicador;
				$data['idUnidad'] = $idUnidad;
				
				$this->cabecera();
				$this->load->view('informes/vwinformeInfo',$data);
				//echo "hay informacion e informe";
			}else{
				//hay informacion pero el informe no esta hecho
				$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
				$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
				$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYPerido($idIndicador,$desde,$hasta);
				$data['periodo'] = $periodo;
				$this->cabecera();
				$this->load->view('informes/vwinforme', $data);
				//echo "hay informacion pero no informe";
			}	
			
		}else{
			// no existe informacion para realizar el informe
			echo "<script type=\"text/javascript\">
					alert('No existen datos en este periodo para este informe')
           			history.go(-1);
       			</script>";
       		
		}
	}

	public function GuardaInforme(){
		$idIndicador = $this->input->post('idIndicador');
		$periodoDet = $this->input->post('periodoDet');
		$periodo = $this->input->post('periodo');
		$comentarios = $this->input->post('comentarios');
		$plan = $this->input->post('plan');
		$resultado = $this->input->post('resultado');
		$rut = $this->session->userdata('rut');
		$this->IndicadorInforme->insertInforme($periodo,$periodoDet,$resultado,$comentarios,$plan,$idIndicador,$rut);
	}

	public function Imprimir(){
		$idIndicador = $_REQUEST['idIndicador'];
		$idUnidad = $_REQUEST['idUnidad'];
		$rut = $this->session->userdata('rut');
		$anio = $_REQUEST['anio'];
		$data['rut'] = $rut;
		//$trimestre = $this->trimestre();
		$usuario = $this->session->userdata('user');
		$cuarto = $_REQUEST['cuarto'];
		$periodo = $cuarto.$anio;
		$desde;
		$hasta;

		list($desde,$hasta) = $this->desdeHasta($cuarto,$anio);
		//list($desde,$hasta) = $this->desdeHasta($cuarto, $anio);
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
		$data['resp'] = $usuario;
		$data['datos2'] = $this->IndicadorInforme->getDatosByIndicadorYPerido($idIndicador,$desde,$hasta);

		if ($data['datos'] != null) {
			$this->load->view('testpdf',$data);
		}else{
			echo "<h3>Todavia no ha hecho un informe para el periodo seleccionado.</h3>";
		}
		
	}

	//llama vista de llistado de indicadores para ver informes, desde perfil supervisor
	public function ReportsIndex(){
		$data['unidades'] = $this->Unidades_model->getAll();
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/informes',$data);
	}

	//carga lista de indicadores por unidad
	public function Reports(){
		$idUnidad = $this->input->post('idUnidad');
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		//$idUnidad = $_REQUEST['idUnidad'];
		$data['lista'] = $this->Indicadores_model->Lista($idUnidad);
		echo json_encode($data);
		/*$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/informes',$data);*/

	}

	//genera informes desde perfil de supervisor
	public function GetReport(){
		$idIndicador = $_REQUEST['idIndicador'];
		$cuarto = $_REQUEST['trimestre'];
		$anio = $_REQUEST['anio'];
		$idUnidad = $_REQUEST['idUnidad'];
		$periodo = $cuarto.$anio;
		$rut_num = $_REQUEST['rut'];

		$desde;
		$hasta;
		$m1;
		$m2;
		$m3;

		list($desde,$hasta) = $this->desdeHasta($cuarto,$anio);

		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
		$data['datos2'] = $this->IndicadorInforme->getDatosByIndicadorYPerido($idIndicador,$desde,$hasta);

		$cliente = new SoapClient('http://192.168.1.51/earancibia/pruebaws/personal.php?wsdl');
		$data['resp'] = $cliente->getNombre($rut_num);

		if ($data['datos'] != null) {
			$this->load->view('testpdf',$data);
		}else{
			echo "<h3>Todavia no ha hecho un informe para el periodo seleccionado.</h3>";
		}
	}

	//llama vista de edicion de informe
	public function UpdateReport(){
		$idIndicador = $_REQUEST['idIndicador'];
		$cuarto = $_REQUEST['trimestre'];
		$anio = $_REQUEST['anio'];
		$idUnidad = $_REQUEST['idUnidad'];
		$periodo = $cuarto.$anio;
		$data['periodo'] = $periodo;
		$desde;
		$hasta;

		list($desde,$hasta) = $this->desdeHasta($cuarto,$anio);

		//$rut_num = $_REQUEST['rut'];
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
		$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
		$data['datos2'] = $this->IndicadorInforme->getDatosByIndicadorYPerido($idIndicador,$desde,$hasta);

		$rut_res2 = $this->IndicadorInforme->getNomResp($idIndicador);
		$rut_ = $rut_res2->rut_res;
		$cliente = new SoapClient('http://192.168.1.51/earancibia/pruebaws/personal.php?wsdl');
		$data['resp'] = $cliente->getNombre($rut_);

		if ($data['datos'] != null) {
			$this->load->view('template/header');
			$this->load->view('template/navSuper');
			$this->load->view('informes/vwinformeInfoEdita',$data);
		}else{
			echo "<h3>Todavia no ha hecho un informe para el periodo seleccionado.</h3>";
		}

	}

	//llama metodo que edita informe
	public function UpdateReport2(){
		$idIndicador = $_REQUEST['idIndicador'];
		//$cuarto = $_REQUEST['trimestre'];
		$fecha = $this->input->post('fecha');
		$periodo = $this->input->post('periodo');
		$resultado = $this->input->post('resultado');
		$periodoDet = $this->input->post('periodoDet');
		$comentario = $this->input->post('comentarios');
		$plan = $this->input->post('plan');

		$this->IndicadorInforme->editaInforme($idIndicador,$periodo,$resultado,$comentario,$plan,$periodoDet,$fecha);
	}

}


