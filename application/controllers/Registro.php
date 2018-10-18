<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registro extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Unidades_model');
		$this->load->model('Cargos_model');
	}

	public function index(){
		$this->NewUser();
	}

	//vista registro usuarios
	public function NewUser(){
		$data['unidadesUser'] = $this->Unidades_model->getAll();
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/registroUsuario',$data);
	}

	//Crea nuevo usuario
	public function AddUser(){
		$rut = $this->input->post('rut');
		$apat = $this->input->post('apat');
		$amat = $this->input->post('amat');
		$nombre = $this->input->post('nombre');
		$pass = $this->input->post('pass');
		$this->Login_model->insertUser($rut,$apat,$amat,$nombre,$pass);
	}

	//comprueba si existe el usuario y busca sus datos al presionar enter
	public function ValidateUser(){
		$rut = $this->input->post('rut_encargado');
		$data['encargado'] = $this->Cargos_model->getDatosUsuario($rut);
		echo json_encode($data);
	}

	//llama vista que modifica la clave de acceso del usuario
	public function Restablecer(){
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/restablecer');
	}

	//modifica la pass
	public function ChangePass(){
		$rut = $this->input->post('rut_usuario');
		$pass = $this->input->post('nueva_pass');
		$this->Login_model->updPass($rut,$pass);
	}
}