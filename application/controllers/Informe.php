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


	//metodo llamado desde el boton INFORME en menu MIS INDICADORES
	public function Informe(){
		$idIndicador = $_REQUEST['idIndicador'];
		$rut = $this->session->userdata('rut');
		$idUnidad = $_REQUEST['idUnidad'];

		$trimestre = $this->trimestre();

		if ($this->IndicadorInforme->existenDatos($idIndicador) == true) {
		//pregunta si hay datos de evaluaciones en en trimestre para realizar el informe
			if ($this->IndicadorInforme->existeInforme($idIndicador) == true) {//pregunta si hay informe hecho este trimestre
				//hay informacion y el informe esta hecho
				$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
				$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
				//$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYrut($idIndicador,1);
				$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$idUnidad,$rut,$trimestre);
				$data['indicador'] = $idIndicador;
				$data['idUnidad'] = $idUnidad;
				
				$this->cabecera();
				$this->load->view('informes/vwinformeInfo',$data);
				//echo "hay informeacion e informe";
			}else{
				//hay informacion pero el informe no esta hecho
				$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
				$data['caracteristica'] = $this->Indicadores_model->getById($idIndicador);
				$data['datos'] = $this->IndicadorInforme->getDatosByIndicadorYrut($idIndicador,$trimestre);
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
		$periodo = $this->input->post('periodo');
		$comentarios = $this->input->post('comentarios');
		$plan = $this->input->post('plan');
		$resultado = $this->input->post('resultado');
		$rut = $this->session->userdata('rut');
		$this->IndicadorInforme->insertInforme($periodo,$resultado,$comentarios,$plan,$idIndicador,$rut);
	}

	public function Imprimir(){
		$idIndicador = $_REQUEST['idIndicador'];
		$idUnidad = $_REQUEST['idUnidad'];
		$rut = $this->session->userdata('rut');
		$data['rut'] = $rut;
		$trimestre = $this->trimestre();
		$usuario = $this->session->userdata('user');
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad($idUnidad);
		$data['datos'] = $this->IndicadorInforme->getDatosInforme($idIndicador,$idUnidad,$rut,$trimestre);
		$data['resp'] = $usuario;
		$this->load->view('testpdf',$data);
	}

}


