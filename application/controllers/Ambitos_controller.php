
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambitos_controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Ambitos');
	}

	public function index(){
		$data['arrAmbitos'] = $this->Ambitos->getAll();
		/*$this->load->view('header');
		$this->load->view('navbar');
		$this->load->view('home', $data);*/
		print_r($data);
	}
}