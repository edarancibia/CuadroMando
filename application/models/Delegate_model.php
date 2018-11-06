<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Delegate_model extends CI_Model{

	//insert
	public function insertDelegate($idIndicador,$to_user){
		$sql = $this->db->query("insert into delegate (idIndicador,to_user) values ('$idIndicador','$to_user')");
	}

	//get
	public function getDelegate($to_user){
		$sql = $this->db->query('select to_user from delegate where to_user='.$to_user.'');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}
}