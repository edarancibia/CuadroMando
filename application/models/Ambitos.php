<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambitos extends CI_Model{
	public function getAll(){
		$query = $this->db->get('Ambitos');
		return $query->result_array();
	}

	public function getCaracteristicasByAmb($idAmbito){
		$this->db->select('idCaracteristica, descripcion, fk_idAmbito');
		$this->db->where('fk_idAmbito', $idAmbito);
		return $this->db->get('Caracteristicas')->result_array();
	}
}