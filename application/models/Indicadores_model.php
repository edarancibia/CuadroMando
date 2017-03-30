<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores_model extends CI_Model{
	public function getByCaracteristica($idCaracteristica){
		$query = $this->db->query('SELECT * FROM Indicadores where fk_idCaracteristica='.$idCaracteristica.'');
		return $query->result_array();
	}

	public function getByCargo($rut_num){
		$query = $this->db->query('SELECT a.idIndicador,d.codigo Caracteristica,a.desc_subUn sub,a.descripcion,a.umbralDesc,a.formula1 '.
									'FROM Indicadores a, Rel_cargoIndicadores b, Cargos c,Caracteristicas d '.
									'WHERE c.idCargo=b.fk_idCargo and b.fk_idIndicador=a.idIndicador AND '.
									'a.fk_idCaracteristica=d.idCaracteristica '.
									'AND c.fk_rut_num='.$rut_num.'');
		return $query->result_array();
	}

	public function getById($idIndicador){
		$query = $this->db->query('SELECT a.*,b.codigo caracteristica
									FROM Indicadores a, Caracteristicas b 
									WHERE a.idIndicador='.$idIndicador.' AND a.fk_idCaracteristica=b.idCaracteristica');
		return $query->row();
	}

	public function insertEvaluacion($denominador,$numerador,$multiplica,$res,$idIndicador,$fecha,$periodo){
		$fecha = getdate();
		$mes = $fecha['mon'];
		$periodoSever = $mes.$fecha['year']; 
		$query = $this->db->query('INSERT INTO IndicadorDatos(denominador,numerador,multiplicador,resultado,fk_idIndicador,fecha,hora,periodo)VALUES('.$denominador.','.$numerador.','.$multiplica.','.$res.','.$idIndicador.',CURRENT_DATE()
			,CURRENT_TIME(),'.$periodoSever.')');
	}

	public function getUltimaEvaluacion($idIndicador){
		$query = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' ORDER BY fecha DESC LIMIT 1');

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return null;
		}
	}

	public function validaFecha($idIndicador){
		$hoy = getdate();
		$periodo = $hoy['mon']. $hoy['year'];
		$query = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' AND periodo='.$periodo.'');
		
		if (empty($query->result())) {
			return false;
		}else{
			return true;
		}
	}

	public function getByAmbito($idAmbito,$trimestre){
		$sql = $this->db->query("SELECT d.fk_idIndicador, b.codigo Caracteristica,a.*,b.idCaracteristica,c.idAmbito,GROUP_CONCAT(DATE_FORMAT(d.fecha,'%d-%m-%Y')ORDER BY d.fecha ASC SEPARATOR ' | ') as fechas,GROUP_CONCAT(d.numerador ORDER BY d.fecha ASC SEPARATOR '    |    ')as numerador,SUM(d.numerador)as numeradores,GROUP_CONCAT(d.denominador ORDER BY d.fecha ASC SEPARATOR '    |    ')as denominador,sum(d.denominador)as denominadores, GROUP_CONCAT(d.resultado ORDER BY d.fecha ASC SEPARATOR '  |  ')as resultados,(SUM(d.numerador)/sum(d.denominador)*100) as res ".
				'FROM Indicadores a '.
					'INNER JOIN Caracteristicas b ON a.fk_idCaracteristica=b.idCaracteristica '.
					'INNER JOIN Ambitos c ON b.fk_idAmbito=c.idAmbito AND c.idAmbito='.$idAmbito.' '.
					'LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND QUARTER(fecha)='.$trimestre.' '.
					'GROUP BY d.fk_idIndicador,b.codigo,b.idCaracteristica,c.idAmbito,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		}else{
			return false;
		}
	}
}


