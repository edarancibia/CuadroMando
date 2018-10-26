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

	//inserta nuevo usuario
	public function insertUser($rut,$apat,$amat,$nombre,$pass){

		$sql = $this->db->query("insert into Usuario (rut_num,a_pat,a_mat,nombre,clave) values('$rut','$apat','$amat','$nombre','$pass')");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//actualiza contraseña
	public function updPass($rut,$pass){
		$sql = $this->db->query("update Usuario set clave='$pass' where rut_num='$rut'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//login
	public function login($rut_num,$pass){
		$sql = $this->db->query("SELECT * FROM Usuario WHERE rut_num='$rut_num' and clave='$pass'");

		if ($sql->num_rows() > 0) {
			return "si";
		}else{
			return "no";
		}
	}

	//obtiene datos user
	public function loginDatos($rut_num){
		$sql = $this->db->query("SELECT * FROM Usuario WHERE rut_num='$rut_num'");

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}

	//update email al crear cargo
	public function updEmail($rut,$email){
		$sql = $this->db->query("update Usuario set email='$email' where rut_num = '$rut'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//obtiene lista de todos los usuarios
	public function getUsers(){
		$sql = $this->db->query('SELECT * FROM Usuario order by a_pat');

		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}
} 