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
}