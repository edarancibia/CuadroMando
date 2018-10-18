<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unidad extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model('Unidades_model');
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
		$desCargo = $this->input->post('desCargo');
		$email = $this->input->post('email');
		$resp = $this->input->post('respCargo');
		$perfil = $this->input->post('perfil');
		$this->Unidades_model->insertUnidad($descrip);

	}

}