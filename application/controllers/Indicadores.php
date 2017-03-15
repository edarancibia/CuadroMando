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
		/*$idCarac = $_GET['idCarac'];
		$data['caracteristicas'] = $this->Caracteristicas->getById($idCarac);
		$data['indicadores'] = $this->Indicadores_model->getByCaracteristica($idCarac);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('indicadores/datosIndicador',$data);*/
		//$this->getIndicaCargo();
	}

	public function redirectCarateristica(){
		$caract = $_GET['idCarac'];
		echo($caract);
	}

	public function misIndicadores(){
		$rut_num = $this->session->userdata('rut');
		$data['indica'] = $this->Indicadores_model->getByCargo($rut_num);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('indicadores/IndicadoresCargo',$data);
	}

	public function detalleIndicador(){
		$idIndicador = $_GET['idIndicador'];
		$data['indicador'] = $this->Indicadores_model->getById($idIndicador);
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('indicadores/datosIndicador',$data);
	}

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

}




