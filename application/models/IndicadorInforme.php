<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndicadorInforme extends CI_Model{

	public function getNombreUnidad($idUnidad){
		$sql = $this->db->query('SELECT * FROM Unidades WHERE idUnidad='.$idUnidad.'');

		if($sql->num_rows() > 0) {
			return $sql->row();
		}else{
			return null;
		}
	}


	public function getDatosByIndicador($idIndicador,$trimestre){
		$sql = $this->db->query("SELECT d.fk_idIndicador, b.codigo Caracteristica,a.*,b.idCaracteristica,GROUP_CONCAT(DATE_FORMAT(d.fecha,'%d-%m-%Y')ORDER BY d.fecha ASC SEPARATOR ' | ') as fechas,GROUP_CONCAT(d.numerador ORDER BY d.fecha ASC SEPARATOR '    |    ')as numerador,SUM(d.numerador)as numeradores,GROUP_CONCAT(d.denominador ORDER BY d.fecha ASC SEPARATOR '    |    ')as denominador,sum(d.denominador)as denominadores, GROUP_CONCAT(d.resultado ORDER BY d.fecha ASC SEPARATOR '  |  ')as resultados,(SUM(d.numerador)/sum(d.denominador)*100) as res ".
				'FROM Indicadores a '.
					'INNER JOIN Caracteristicas b ON a.fk_idCaracteristica=b.idCaracteristica '.
					'LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND QUARTER(fecha)='.$trimestre.' '.
					'WHERE d.fk_idIndicador='.$idIndicador.' '.
					'GROUP BY d.fk_idIndicador,b.codigo,b.idCaracteristica,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() > 0) {
			return $sql->row();
		}else{
			return false;
		}
	}

	public function insertInforme($resultado,$comentarios,$plan,$idIndicador){
		$fecha = getdate();
		$mes = $fecha['mon'];
		$periodoSever = $mes.$fecha['year'];

		$sql = $this->db->query('INSERT INTO IndicadorInformes(fecha,periodo,resultado,comentarios,plan,fk_idIndicador)
								VALUES()');
	}
}





