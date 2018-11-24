<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unidad extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Unidades_model');
		$this->load->model('Cargos_model');
	}

	public function index(){
		$this->templateSupervisor();
	}

	public function templateSupervisor(){
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/unidad');
	}

	public function Add(){
		$descrip = $this->input->post('desc');
		$resp = $this->input->post('respCargo');
		$this->Unidades_model->insertUnidad($descrip);
	}

}