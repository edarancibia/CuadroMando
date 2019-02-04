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
	public function insertCargo($desc,$rut,$email,$perfil){
		$sql = $this->db->query("insert into Cargos(descripcion,fk_rut_num,email,perfil)values
									('$desc','$rut','$email','$perfil')");

		$query = $this->db->query('SELECT LAST_INSERT_ID()');
	    $row = $query->row_array();
	    $LastIdInserted = $row['LAST_INSERT_ID()'];
	    return $LastIdInserted;
	}

	//crear realcion cargo/unidad
	public function cargoUnidad($cargo,$unidad){
		$sql = $this->db->query("insert into rel_cargoUnidad (fk_idCargo,fk_id_unidad) values('$cargo','$unidad')");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//crear realcion cargo/unidad
	public function updJefe($rut){
		$sql = $this->db->query("update Cargos set fk_rut_num = '$rut'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//crear realcion cargo/unidad
	public function updCargoUnidad($cargo,$unidad){
		$sql = $this->db->query("update rel_cargoUnidad set fk_idCargo = '$cargo' where fk_idCargo='$cargo')");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//get idcargo
	public function getIdCargo($rut){
		$sql = $this->db->query("select * from Cargos where fk_rut_num = '$rut'");

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}

	//get idcargo del nuevo rut
	public function getIdCargo2($rut_nuevo){
		$sql = $this->db->query("select * from Cargos where fk_rut_num = '$rut_nuevo'");

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}

	//upd cargo
	public function updCargo($rut_actual,$rut_nuevo){
		$sql = $this->db->query("update Cargos set fk_rut_num = '$rut_nuevo' where fk_rut_num = '$rut_actual'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//upd rel caroUnidad
	public function updRelCargoUnidad($rut_actual,$rut_nuevo){
		$sql = $this->db->query("update rel_cargoUnidad set fk_rut_num = '$rut_nuevo' where fk_rut_num = '$rut_actual'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//update rel_cargoIndicadores
	public function updRelCargoIndicadores($cargo_actual,$cargo_nuevo){
		$sql = $this->db->query("update rel_cargoIndicadores set fk_idCargo = '$rut_nuevo' where fk_rut_num = '$rut_actual'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//get by ID
	public function getRutCargo($idCargo){
		$sql = $this->db->query("select fk_rut_num from Cargos where idCargo = '$idCargo'");

		if ($sql->num_rows() > 0) {
			return $res = $sql->row();
		}else{
			return null;
		}
	}

}