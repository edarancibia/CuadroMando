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


	//obtiene la informacion de evaluacion de indicador por ID y RUT
	public function getDatosByIndicadorYrut($idIndicador,$trimestre){
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

	//obtiene la informacion del informe correspondiente al trimestre actual, por responsable y unidad
	public function getDatosInforme($idIndicador,$idUnidad,$rut,$trimestre){
		$sql = $this->db->query('SELECT DISTINCT  b.*,b.descripcion indicadorDesc,c.codigo,a.fecha,a.resultadoDet,a.periodo,a.comentarios,a.plan,f.descripcion
									FROM IndicadorInformes a, Indicadores b, Caracteristicas c,Rel_cargoIndicadores d, rel_indicadorUnidades e,Unidades f,Cargos g
									WHERE b.idIndicador='.$idIndicador.' AND a.fk_idIndicador=b.idIndicador AND b.fk_idCaracteristica=c.idCaracteristica
									AND b.idIndicador=d.fk_idIndicador AND f.idUnidad='.$idUnidad.' AND e.fk_idUnidad=f.idUnidad AND g.idCargo=d.fk_idCargo AND g.fk_rut_num='.$rut.' AND QUARTER(a.fecha)='.$trimestre.'');

		if ($sql->num_rows() > 0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	public function insertInforme($periodo,$resultado,$comentarios,$plan,$idIndicador,$rut){
		//$fecha = getdate();
		//$mes = $fecha['mon'];
		//$periodoSever = $mes.$fecha['year'];

		$sql = $this->db->query("INSERT INTO IndicadorInformes(fecha,periodo,resultadoDet,resultado,comentarios,plan,fk_idIndicador,fk_rut_num)   
									VALUES(CURRENT_DATE(),'$periodo','$resultado',0,'$comentarios','$plan','$idIndicador','$rut')");
	}

	public function existeInforme($idIndicador){
		$sql = $this->db->query('SELECT * FROM IndicadorInformes WHERE fk_idIndicador='.$idIndicador.' and QUARTER(fecha)=2');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	public function existenDatos($idIndicador){
		$sql = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' AND QUARTER(fecha)=2');

		if ($sql->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

}







