<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caracteristicas extends CI_Model{
	public function getByAmbito($codAmbito){
		$query = $this->db->query('SELECT * FROM Caracteristicas WHERE fk_idAmbito='.$codAmbito.'');
		return $query->result_array();
	}
}