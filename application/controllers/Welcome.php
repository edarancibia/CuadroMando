<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Ambitos');
		$this->load->model('Caracteristicas');
		$this->load->model('Unidades_model');
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('login/login');
	}

	public function home(){
		$this->cabecera();
		$this->load->view('inicio');
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->load->view('template/header');
		$this->load->view('login/login');
	}

	public function HomeSupervisor(){
		$data['servicios2'] = $this->Unidades_model->getAll2();
		$this->cabeceraSupervisor();
		$this->load->view('supervisor/home',$data);
	}

	public function cabecera(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
	}

	public function cabeceraSupervisor(){
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
	}

}
