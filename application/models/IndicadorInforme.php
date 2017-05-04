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


	//obtiene la informacion de evaluacion de indicador por ID y periodo
	public function getDatosByIndicadorYPerido($idIndicador,$desde,$hasta){
		$sql = $this->db->query("SELECT d.fk_idIndicador, b.codigo Caracteristica,a.*,b.idCaracteristica,GROUP_CONCAT(DATE_FORMAT(d.fecha,'%d-%m-%Y')ORDER BY d.fecha ASC SEPARATOR ' | ') as fechas,GROUP_CONCAT(d.numerador ORDER BY d.fecha ASC SEPARATOR '    |    ')as numerador,SUM(d.numerador)as numeradores,GROUP_CONCAT(d.denominador ORDER BY d.fecha ASC SEPARATOR '    |    ')as denominador,sum(d.denominador)as denominadores, GROUP_CONCAT(d.resultado ORDER BY d.fecha ASC SEPARATOR '  |  ')as resultados,(SUM(d.denominador)/sum(d.numerador)*100) as res ".
				'FROM Indicadores a '.
					'INNER JOIN Caracteristicas b ON a.fk_idCaracteristica=b.idCaracteristica '.
					'LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND d.periodo BETWEEN '.$desde.' AND '.$hasta.' '.
					'WHERE d.fk_idIndicador='.$idIndicador.' '.
					'GROUP BY d.fk_idIndicador,b.codigo,b.idCaracteristica,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() > 0) {
			return $sql->row();
		}else{
			return false;
		}
	}

	//obtiene la informacion del informe correspondiente al trimestre actual, por responsable y unidad
	public function getDatosInforme($idIndicador,$periodo){
		$sql = $this->db->query('SELECT DISTINCT  b.*,b.descripcion indicadorDesc,c.codigo,a.fecha,a.resultadoDet,a.periodoDet,a.comentarios,a.plan
									FROM IndicadorInformes a, Indicadores b, Caracteristicas c
									WHERE b.idIndicador='.$idIndicador.' AND a.fk_idIndicador=b.idIndicador AND b.fk_idCaracteristica=c.idCaracteristica AND a.periodo='.$periodo.'');

		if ($sql->num_rows() > 0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	//INSERT INFORME
	public function insertInforme($periodo,$periodoDet,$resultado,$comentarios,$plan,$idIndicador,$rut){

		$sql = $this->db->query("INSERT INTO IndicadorInformes(fecha,periodo,periodoDet,resultadoDet,resultado,comentarios,plan,fk_idIndicador,fk_rut_num)   
									VALUES(CURRENT_DATE(),'$periodo','$periodoDet','$resultado',0,'$comentarios','$plan','$idIndicador','$rut')");
	}

	//COMPRUEBA SI HAY INFORME REALIZADO DE UN INDICACADOR DURANTE UN TRIMESTRE SELECCIONADO
	public function existeInforme($idIndicador,$anio,$periodo){
		$sql = $this->db->query('SELECT * FROM IndicadorInformes WHERE fk_idIndicador='.$idIndicador.' and YEAR(fecha)='.$anio.' and periodo='.$periodo.'');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	//COMPRUEBA SI HAY DATOS DE UN INDICACADOR DURANTE UN TRIMESTRE SELECCIONADO
	public function existenDatos($idIndicador,$anio,$cuarto){
		$sql = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' AND YEAR(fecha)='.$anio.' AND QUARTER(fecha)='.$cuarto.'');

		if ($sql->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

}







