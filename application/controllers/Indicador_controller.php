<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicador_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$this->load->view('template/header');
		$this->load->view('template/navbar');
		$this->load->view('home');
	}
}