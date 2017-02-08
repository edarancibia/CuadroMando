<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambitos extends CI_Model{
	public function getAll(){
		$query = $this->db->get('Ambitos');
		return $query->result_array();
	}
}