<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

	public function getCargo($rut_num){
		$sql = $this->db->query('SELECT * FROM Cargos WHERE fk_rut_num='.$rut_num.'');

		if ($sql->num_rows() > 0) {
			$res = $sql->row();

			if ($res->perfil == 1) {
				return true;
			}else{
				return false;
			}
		}else{
			return null;
		}
	}

	public function getCargo2($rut_num){
		$sql = $this->db->query('SELECT * FROM Cargos WHERE fk_rut_num='.$rut_num.'');

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}
} 