<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambitos_controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Ambitos');
	}

	public function index(){
		$data['arrAmbitos'] = $this->Ambitos->getAll();
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('home',$data);
	}

	public function getAmbitos(){
		$data['arrAmbitos'] = $this->Ambitos->getAll();
		echo json_encode($data);
	}

	public function getAjaxCaracteristicas(){
		$idAmbito = $this->input->post('cboAmbitos');
		$data['caracteristicas'] = $this->Ambitos->getCaracteristicasByAmb($idAmbito);
		//echo json_encode($data);
		echo 'el id es: ' . $idAmbito;
	}
}