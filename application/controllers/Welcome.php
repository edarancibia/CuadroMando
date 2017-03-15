<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Ambitos');
		$this->load->model('Caracteristicas');
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('login/login');
		//$this->datos();
	}

	public function home(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('inicio');
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->load->view('template/header');
		$this->load->view('login/login');
	}
}