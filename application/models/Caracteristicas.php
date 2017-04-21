<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caracteristicas extends CI_Model{
	public function getByAmbito($codAmbito){
		$query = $this->db->query('SELECT * FROM Caracteristicas WHERE fk_idAmbito='.$codAmbito.'');
		return $query->result_array();
	}

	public function getById($idCaracteristica){
		$query = $this->db->query('SELECT * FROM Caracteristicas WHERE idCaracteristica='.$idCaracteristica.'');
		return $query->row();
	}

	//BUSCA TODOS LOS DATOS DE LA TABLA PARA EL AUTOCOMPLETADOR
	function get_caracteristica($q){
	    $this->db->select('*');
	    $this->db->like('codigo', $q);
	    $query = $this->db->get('Caracteristicas');
	    if($query->num_rows() > 0){
	      foreach ($query->result_array() as $row){
	        $new_row['label']=htmlentities(stripslashes($row['codigo']));
	        $new_row['value']=htmlentities(stripslashes($row['idCaracteristica']));
	        $row_set[] = $new_row; //build an array
	      }
	      echo json_encode($row_set); //format the array into json data
	    }
	 }
}