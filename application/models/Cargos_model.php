<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos_model extends CI_Model{

	//CARGA TODOS LOS CARGOS DE LA TABLA
	public function getAll(){
		$this->db->order_by('descripcion','asc');
		$cargo = $this->db->get('Cargos');

		if ($cargo->num_rows()>0) {
			return $cargo->result();
		}
	}
}