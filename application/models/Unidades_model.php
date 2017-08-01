<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades_model extends CI_Model{

	//CARGA TODAS LAS UNIDADES DE LA TABLA
	public function getAll(){
		$this->db->order_by('descripcion','asc');
		$unidad = $this->db->get('Unidades');

		if ($unidad->num_rows()>0) {
			return $unidad->result();
		}
	}

	//busca unidades a cargo del usuario
	public function getUnidades($idCargo){
		$sql = $this->db->query('SELECT * FROM rel_cargoUnidad a,  Unidades b  WHERE a.fk_id_unidad = b.idUnidad AND a.fk_idCargo='.$idCargo.'');

		if ($sql->num_rows()>0) {
			return $sql->result();
		}
	}
}