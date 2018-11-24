<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registro extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Unidades_model');
		$this->load->model('Cargos_model');
		$this->load->model('Delegate_model');
		$this->load->model('Indicadores_model');
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

		$perfil = $this->input->post('perfil');
		$email = $this->input->post('email');
		$unidad = $this->input->post('unidad');
		$cargo = $this->input->post('cargo');

		$this->Login_model->insertUser($rut,$apat,$amat,$nombre,$pass);

		$idcargo = $this->Cargos_model->insertCargo($cargo,$rut,$email,$perfil);

		$this->Cargos_model->cargoUnidad($idcargo,$unidad);

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

	//modifica usuario responsable de unidad
	public function Reemplazar(){
		$data['users'] = $this->Login_model->getUsers();
		$this->load->view('template/header');
		$this->load->view('template/navSuper');
		$this->load->view('supervisor/reemplazarUser',$data);
	}

	//llama vista reemplazar
	public function ReemplazarLista(){
		$rut_actual = $this->input->post('rut_actual');
		$data['indicadores_reemplazar'] = $this->Indicadores_model->getByUsuarioNew($rut_actual);
		echo json_encode($data);
	}

	//Guarda relacion reemplazo usuario-indicador (delegate)
	public function InsertDelegate_(){
		$rut_nuevo = $this->input->post('rut_nuevo');
		$idIndicador = $this->input->post('idIndicador');
		$data = $this->Indicadores_model->getCargo($rut_nuevo);
		$idCargo = $data->idCargo;
		$this->Indicadores_model->updateRelCagoIndicador($rut_nuevo,$idIndicador,$idCargo);
	}

}