<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Ambitos');
		$this->load->model('Caracteristicas');
		$this->load->model('Unidades_model');
		$this->load->model('Indicadores_model');
		$this->load->model('Delegate_model');
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('login/login');
	}

	public function home(){
		$this->cabecera();
		//$this->load->view('inicio');
		$this->MisIndicadores();
	}

	//metodo que busca Los indicadores asisgnados por unidad y usuario
	public function MisIndicadores(){
		$rut = $this->session->userdata('rut');
		$data['indica'] = $this->Indicadores_model->getByUsuario($rut);
		//$data['nomUnidad'] = $this->NombreUnidad($idUnidad);

		//$this->template();
		$this->load->view('indicadores/indicadoresCargo',$data);
	}

	//metodo que busca Los indicadores del usuario reemplazado
	public function Reemplazando(){

		$rut = $this->session->userdata('rut');
		//$reem = $this->Delegate_model->getDelegate($rut);
		//$to_user = $reem->to_user;
		$data['indicaReemplaza'] = $this->Indicadores_model->getByUsuarioDelegate($rut);
		//$data['nomUnidad'] = $this->NombreUnidad($idUnidad);

		//$this->template();
		$this->cabecera();
		$this->load->view('encargado/reemplazar',$data);
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
