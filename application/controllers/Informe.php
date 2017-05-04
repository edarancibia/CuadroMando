<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informe extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('IndicadorInforme');
		$this->load->model('Caracteristicas');
		$this->load->model('Indicadores_model');	
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

			$desde = $m1.$anio;
			$hasta = $m3.$anio;
			return array($desde,$hasta);
		}

		if ($cuarto == 2) {
			$m1 = 4;
			$m2 = 5;
			$m3 = 6;
			$desde = $m1.$anio;
			$hasta = $m3.$anio;
			return array($desde,$hasta);
		}

		if ($cuarto == 3) {
			$m1 = 7;
			$m2 = 8;
			$m3 = 9;
			$desde = $m1.$anio;
			$hasta = $m3.$anio;
			return array($desde,$hasta);
		}

		if ($cuarto == 4) {
			$m1 = 10;
			$m2 = 11;
			$m3 = 12;
			$desde = $m1.$anio;
			$hasta = $m3.$anio;
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
		if ($this->IndicadorInforme->existenDatos($idIndicador,$anio,$cuarto) == true) {
		
			if ($this->IndicadorInforme->existeInforme($idIndicador,$anio,$periodo) == true) {//pregunta si hay informe hecho este trimestre
				//hay informacion y el informe esta hecho
				$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
				$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
				//$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYrut($idIndicador,1);
				$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
				$data['indicador'] = $idIndicador;
				$data['idUnidad'] = $idUnidad;
				
				$this->cabecera();
				$this->load->view('informes/vwinformeInfo',$data);
				//echo "hay informeacion e informe";
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
		//list($desde,$hasta) = $this->desdeHasta($cuarto, $anio);
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$periodo);
		$data['resp'] = $usuario;

		if ($data['datos'] != null) {
			$this->load->view('testpdf',$data);
		}else{
			echo "<h3>Todavia no ha hecho un informe para el periodo seleccionado.</h3>";
		}
		
	}

}


