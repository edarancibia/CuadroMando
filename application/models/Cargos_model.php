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

	//obtiene datos de usuario 
	public function getDatosUsuario($rut){
		$sql = $this->db->query('select * from Usuario where rut_num='.$rut.'');

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}

	//insert nuevo cargo
	public function insertCargo($rut,$desc,$email,$perfil){
		$sql = $this->db->query("insert into Cargos(descripcion,fk_rut_num,email,perfil)values
									('$desc','$rut,$email','$perfil')");

		$query = $this->db->query('SELECT LAST_INSERT_ID()');
	    $row = $query->row_array();
	    $LastIdInserted = $row['LAST_INSERT_ID()'];
	    return $LastIdInserted;
	}

}