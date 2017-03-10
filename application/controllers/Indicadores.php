<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Indicadores_model');
		$this->load->model('Caracteristicas');
	}

	public function index(){
		/*$data['caracteristicas'] = $this->Caracteristicas->getById(1);
		$data['indicadores'] = $this->Indicadores_model->getByCaracteristica(1);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('datosIndicador',$data);*/
	}

	public function redirectCarateristica(){
		$caract = $_GET['idCarac'];
		echo($caract);
	}

	public function getIndicaCargo(){
		$rut_num = $this->input->post('rut');
		$data['indica'] = $this->Indicadores_model->getByCargo($rut_num);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('IndicadoresCargo',$data);
		echo(json_encode($data));
	}
}