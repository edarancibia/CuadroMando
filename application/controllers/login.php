<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
	}

	public function wsLoginSicbo(){
		$rut_num = $this->input->post('rut_num');
		$clave = $this->input->post('clave');
		$cliente = new SoapClient('http://192.168.1.51/earancibia/pruebaws/loginCmando.php?wsdl');
		$result = $cliente->verificaUsuario($rut_num,$clave);

		if ($result == "si") {
			echo "pasa";
			$this->session->set_userdata('rut',$rut_num);
		}else{
			echo "no pasa";
		}
	}
	
	public function validaCargo(){
		$rut_num = $this->input->post('rut_num');
		$data = $this->Login_model->getCargo($rut_num);

		if ($data == 1) {
			echo "1";
		}else if ($data == 0) {
			echo "0";
		}else{
			echo "no esta en sistema de calidad";
		}
	}
}