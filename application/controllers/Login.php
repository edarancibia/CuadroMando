<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('Unidades_model');
	}

	public function Login(){
		$rut_num = $this->input->post('rut');
		$clave = $this->input->post('password');
		//$cliente = new SoapClient('http://192.168.1.51/earancibia/pruebaws/loginCmando.php?wsdl');
		//$result = $cliente->verificaUsuario($rut_num,$clave);
		$result = $this->Login_model->login($rut_num,$clave);


		if ($result == "si") {
			//echo "pasa";
			$rut_num = $this->input->post('rut');
			if ($this->validaCargo($rut_num) == 1) {
				$this->getNombreUsuario();
				$this->session->set_userdata('rut',$rut_num);
				$this->load->view('template/header');
				$this->load->view('template/navSuper');
				//$this->load->view('supervisor/home');
				$data['servicios2'] = $this->Unidades_model->getAll2();
				
				$this->load->view('supervisor/home',$data);
			}else{
				$this->getNombreUsuario();
				$this->session->set_userdata('rut',$rut_num);
				$this->cabecera();
				$this->load->view('inicio');
			}
		}else{
			echo "<script>alert('Usuario o contraseña incorrectos')</script>";
			$this->load->view('template/header');
			$this->load->view('login/login');
		}
	}

	public function cabecera(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
	}

	public function getNombreUsuario(){
		$rut_num = $this->input->post('rut');
		//$cliente = new SoapClient('http://192.168.1.51/earancibia/pruebaws/personal.php?wsdl');
		//$result = $cliente->getNombre($rut_num);
		$result = $this->Login_model->loginDatos($rut_num);
		$this->session->set_userdata('user',$result);
	}
	
	public function validaCargo($rut_num){
		//$rut_num = $this->input->post('rut_num');
		$data = $this->Login_model->getCargo($rut_num);

		if ($data == 1) {
			$this->session->set_userdata('cargo',1);
			return true;
		}else if ($data == 0) {
			$this->session->set_userdata('cargo',0);
			return false;
		}else{
			return null;
			//echo "no esta en sistema de calidad";
		}
	}

}