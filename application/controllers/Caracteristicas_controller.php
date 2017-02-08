<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caracteristicas_controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Caracteristicas');
	}

}