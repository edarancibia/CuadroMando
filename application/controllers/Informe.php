<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informe extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('IndicadorInforme');
		$this->load->model('Caracteristicas');
		$this->load->model('Indicadores_model');		
	}

	public function InformacionGeneral(){
		//$idUnidad = $_REQUEST['idUnidad'];
		//$idIndicador = $_REQUEST['idIndicador'];
		$data['unidad'] = $this->IndicadorInforme->getNombreUnidad(1);
		$data['caracteristica'] = $this->Indicadores_model->getById(21);
		$data['datos'] = $this->IndicadorInforme->getDatosByIndicador(21,1);
		
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('informes/vwinforme',$data);
	}
}