<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Delegate_model extends CI_Model{

	//insert
	public function insertDelegate($from,$to){
		$sql = $this->db->query("insert into delegate (from_user,to_user) values ('$from','$to')");
	}

	//get
	public function getDelegate($from){
		$sql = $this->db->query('select to_user from delegate where from_user='.$from.'');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}
}