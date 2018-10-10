<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registro extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
	}

	//vista registro usuarios
	public function NewUser(){
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/registroUsuario');
	}

	//Crea nuevo usuario
	public function AddUser(){
		$rut = $this->input->post('rut');
		$pass = $this->input->post('pass');
		$this->Login_model->insertUser($rut,$pass);
	}
}