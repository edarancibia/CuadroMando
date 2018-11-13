<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores_model extends CI_Model{

	//GRABA NUEVO INDICADOR EN LA BD
	public function insert($subUn,$desc,$umbral,$f1,$f2,$umbralDesc,$idCaracteristica){

		$data = array(
			'desc_subUn' => $subUn,
			'descripcion' => $desc,
			'umbral' => $umbral,
			'formula1' => $f1  ,
			'formula2' => $f2,
			'umbralDesc' => $umbralDesc,
			'fk_idCaracteristica' => $idCaracteristica
		);

		$this->db->insert('Indicadores', $data);
		//$ultimo = $this->db->insert_id();
		//return $ultimo;

		$query = $this->db->query('SELECT LAST_INSERT_ID()');
	    $row = $query->row_array();
	    $LastIdInserted = $row['LAST_INSERT_ID()'];
	    return $LastIdInserted;
	}

	//GRABA NUEVA RELACION INDICADOR-UNIDAD
	public function relIndUni($idIndicador,$idUnidad){
		$sql = $this->db->query('INSERT INTO rel_indicadorUnidades(fk_idIndicador,fk_idUnidad)VALUES('.$idIndicador.','.$idUnidad.')');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//GRABA NUEVA RELACION INDICADOR-RESPONSABLE
	public function relIndCargo($idIndicador,$idCargo){
		$sql = $this->db->query('INSERT INTO Rel_cargoIndicadores(fk_idCargo,fk_idIndicador)VALUES('.$idCargo.','.$idIndicador.')');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

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
			,CURRENT_TIME(),'.$periodo.')');
	}

	public function getUltimaEvaluacion($idIndicador){
		$query = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' ORDER BY fecha DESC LIMIT 1');

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return null;
		}
	}

	//VALIDAD QUE NO SE INGRESEN DATOS MAS DE UNA VEZ AL MES
	public function validaFecha($idIndicador,$periodo){
		$hoy = getdate();
		//$periodo = $hoy['mon']. $hoy['year'];
		$query = $this->db->query('SELECT * FROM IndicadorDatos WHERE fk_idIndicador='.$idIndicador.' AND periodo='.$periodo.'');
		
		if (empty($query->result())) {
			return false;
		}else{
			return true;
		}
	}

	//BUSCA Y MUESTRA LISTADO DE INDICADORES Y SUS DATOS MENSUALES Y TRIMESTRALES POR AMBITO
	public function getByAmbito($idAmbito,$anio,$desde,$hasta){
		$sql = $this->db->query("SELECT d.fk_idIndicador, b.codigo Caracteristica,a.*,b.idCaracteristica,c.idAmbito,GROUP_CONCAT(DATE_FORMAT(d.fecha,'%d-%m-%Y')ORDER BY d.fecha ASC SEPARATOR ' | ') as fechas,GROUP_CONCAT(d.numerador ORDER BY d.fecha ASC SEPARATOR '    |    ')as numerador,SUM(d.numerador)as numeradores,GROUP_CONCAT(d.denominador ORDER BY d.fecha ASC SEPARATOR '    |    ')as denominador,sum(d.denominador)as denominadores, GROUP_CONCAT(d.resultado ORDER BY d.fecha ASC SEPARATOR '  |  ')as resultados,round((SUM(d.denominador)/sum(d.numerador)*100)) as res,
			IF(round((SUM(d.denominador)/sum(d.numerador)*100),0) >= a.umbral,'SI','NO')as evaluacion ".
				'FROM Indicadores a '.
					'INNER JOIN Caracteristicas b ON a.fk_idCaracteristica=b.idCaracteristica '.
					'INNER JOIN Ambitos c ON b.fk_idAmbito=c.idAmbito AND c.idAmbito='.$idAmbito.' '.
					'LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND YEAR(d.fecha)='.$anio.' AND periodo BETWEEN '.$desde.' AND '.$hasta.' '.
					'GROUP BY d.fk_idIndicador,b.codigo,b.idCaracteristica,c.idAmbito,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		}else{
			return false;
		}
	}

	//listado de indicadores por unidad y cargo 
	public function getByCargoYunidad($rut,$idUnidad){
		$sql = $this->db->query("SELECT a.idIndicador,f.codigo Caracteristica,a.desc_subUn sub,a.descripcion,a.umbralDesc,a.formula1
								from Indicadores a,Unidades b, Cargos c,Rel_cargoIndicadores d,rel_indicadorUnidades e,Caracteristicas f ".
								'WHERE c.fk_rut_num='.$rut.' AND c.idCargo=d.fk_idCargo AND a.idIndicador=d.fk_idIndicador AND b.idUnidad='.$idUnidad.' AND a.idIndicador=e.fk_idIndicador AND b.idUnidad=e.fk_idUnidad AND f.idCaracteristica=a.fk_idCaracteristica');

		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		}else{
			return false;
		}
	}

	//listado de indicadores por cargo,unidad y sub division
	public function getByCargoUnidadYsubd($rut,$idUnidad,$subd){
		$sql = $this->db->query("SELECT a.idIndicador,f.codigo Caracteristica,a.desc_subUn sub,a.descripcion,a.umbralDesc,a.formula1
								from Indicadores a,Unidades b, Cargos c,Rel_cargoIndicadores d,rel_indicadorUnidades e,Caracteristicas f, SubDivision g ".
								"WHERE c.fk_rut_num='.$rut.' AND c.idCargo=d.fk_idCargo AND a.idIndicador=d.fk_idIndicador AND b.idUnidad='.$idUnidad.'
								AND a.idIndicador=e.fk_idIndicador AND b.idUnidad=e.fk_idUnidad AND f.idCaracteristica=a.fk_idCaracteristica 
								and g.fk_idUnidad=1 AND g.descripcion='$subd' AND a.desc_subUn like '%$subd' ");

		if ($sql->num_rows() > 0) {
			return $sql->result_array();
		}else{
			return false;
		}
	}

	//BUSCA Y MUESTRA LISTADO DE INDICADORES Y SUS DATOS MENSUALES Y TRIMESTRALES POR UNIDAD
	public function getByUnidad($idUnidad,$anio,$desde,$hasta){
		$sql = $this->db->query("SELECT d.fk_idIndicador,e.codigo Caracteristica,a.*,c.idUnidad,GROUP_CONCAT(DATE_FORMAT(d.fecha,'%d-%m-%Y')ORDER BY 	d.fecha ASC SEPARATOR ' | ') as fechas,GROUP_CONCAT(d.numerador ORDER BY d.fecha ASC SEPARATOR '    |    ')as numerador,SUM(d.numerador)as numeradores,GROUP_CONCAT(d.denominador ORDER BY d.fecha ASC SEPARATOR '    |    ')as denominador,sum(d.denominador)as denominadores, GROUP_CONCAT(d.resultado ORDER BY d.fecha ASC SEPARATOR '  |  ')as resultados,round((SUM(d.denominador)/sum(d.numerador)*100)) as res,
			IF(round((SUM(d.denominador)/sum(d.numerador)*100),0) >= a.umbral,'SI','NO')as evaluacion ".
			'FROM Indicadores a
			INNER JOIN rel_indicadorUnidades b ON a.idIndicador=b.fk_idIndicador
			INNER JOIN Unidades c ON b.fk_idUnidad=c.idUnidad AND c.idUnidad='.$idUnidad.'
			INNER JOIN Caracteristicas e ON a.fk_idCaracteristica=e.idCaracteristica
			LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND YEAR(d.fecha)='.$anio.' AND periodo BETWEEN '.$desde.' AND '.$hasta.'
			GROUP BY  d.fk_idIndicador,e.codigo,e.idCaracteristica,c.idUnidad,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}

	//OBTIENE LOS DATOS DEL RESPONSABLE DEL INDICADOR SELECCIONADO
	public function getDatosResponsable($idIndicador){
		$sql = $this->db->query('SELECT a.* FROM Cargos a, Rel_cargoIndicadores b
									WHERE b.fk_idIndicador='.$idIndicador.' AND b.fk_idCargo=a.idCargo');
		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}

	}

	//obtiene lista de indicadores por unidad, para modulo de mantencion de responsables
	public function getIndicadoresMan($idUnidad){
		$sql = $this->db->query('SELECT a.*,c.codigo
				from Indicadores a, rel_indicadorUnidades b, Caracteristicas c
				WHERE a.idIndicador=b.fk_idIndicador AND b.fk_idUnidad='.$idUnidad.' AND a.fk_idCaracteristica=c.idCaracteristica');

		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}

	//obtiene datos para vista rapida de cuadro de mando
	public function getPreview($anio,$desde,$hasta){
		$sql = $this->db->query("SELECT e.codigo Caracteristica,a.descripcion,a.umbralDesc,c.idUnidad,round((SUM(d.denominador)/sum(d.	numerador)*100)) as res,c.descripcion Unidad,a.umbral,
								IF(round((SUM(d.denominador)/sum(d.numerador)*100),0) >= a.umbral,'SI','NO')as evaluacion ".
								'FROM Indicadores a
								INNER JOIN rel_indicadorUnidades b ON a.idIndicador=b.fk_idIndicador
								INNER JOIN Unidades c ON b.fk_idUnidad=c.idUnidad 
								INNER JOIN Caracteristicas e ON a.fk_idCaracteristica=e.idCaracteristica
								LEFT JOIN IndicadorDatos d ON a.idIndicador=d.fk_idIndicador AND YEAR(d.fecha)='.$anio.' AND d.periodo BETWEEN '.$desde.' AND '.$hasta.'
								GROUP BY c.descripcion, d.fk_idIndicador,e.codigo,e.idCaracteristica,c.idUnidad,a.idIndicador,a.codigo,a.desc_subUn,a.descripcion,a.fk_idCaracteristica,a.formula1,a.formula2,a.umbral,a.umbralDesc');

		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}

	}

	//obtiene lista de indicadores, para ver informes desde perfil supervisor
	public function Lista($idUnidad){
		$sql = $this->db->query("SELECT b.codigo carac, a.idIndicador,a.desc_subUn,a.descripcion descInd,d.descripcion responsable,d.idCargo cargo,d.fk_rut_num rut ".
									'FROM Indicadores a, Caracteristicas b,Rel_cargoIndicadores c,Cargos d,rel_indicadorUnidades e
									WHERE  a.fk_idCaracteristica=b.idCaracteristica AND a.idIndicador=c.fk_idIndicador AND c.fk_idCargo=d.idCargo and e.fk_idIndicador=a.idIndicador and e.fk_idUnidad='.$idUnidad.'');
		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}

	//obtiene los datos de evaluacion mensual de un indicador
	public function getDataIndicador($idIndicador,$periodo){
		$sql = $this->db->query('SELECT c.codigo cod_c,a.*,b.* FROM Indicadores a ,IndicadorDatos b,Caracteristicas c WHERE a.idIndicador=b.fk_idIndicador AND a.idIndicador='.$idIndicador.' AND b.periodo='.$periodo.' and a.fk_idCaracteristica=c.idCaracteristica');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	//modifica datos de evalucion de indicador
	public function editaDatos($idIndicador,$periodo,$numerador,$denominador){
		$sql = $this->db->query('UPDATE IndicadorDatos SET numerador='.$numerador.',denominador='.$denominador.' WHERE fk_idIndicador='.$idIndicador.' AND periodo='.$periodo.'');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//obtiene umbral
	public function getUmbral($idIndicador){
		$sql = $this->db->query('SELECT umbralDesc FROM Indicadores where idIndicador='.$idIndicador.'');

		if ($sql->num_rows() >0) {
			return $sql->row();
		}else{
			return null;
		}
	}

	//actualiza umbral
	public function updUmbral($idIndicador,$umbral,$umbralDesc){
		$sql = $this->db->query("update Indicadores set umbral='$umbral', umbralDesc='$umbralDesc' where idIndicador='$idIndicador'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	//get indicadores por usuario
	public function getByUsuario($rut){
		$sql = $this->db->query('SELECT b.idUnidad, a.idIndicador,b.descripcion as unidad, f.codigo Caracteristica,a.desc_subUn sub,a.descripcion,a.umbralDesc,a.formula1 '.
				'from Indicadores a,Unidades b, Cargos c,Rel_cargoIndicadores d,rel_indicadorUnidades e,Caracteristicas f '.
				"WHERE c.fk_rut_num='$rut' AND c.idCargo=d.fk_idCargo 
				AND a.idIndicador=d.fk_idIndicador
				AND a.idIndicador=e.fk_idIndicador AND b.idUnidad=e.fk_idUnidad 
				AND f.idCaracteristica=a.fk_idCaracteristica
				order by unidad asc");

		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}

	//get indicadores por usuario nueva segun table rel_cargoIndicador
	public function getByUsuarioNew($rut_res){
		$sql = $this->db->query('SELECT b.idUnidad, a.idIndicador,b.descripcion as unidad, 
								f.codigo Caracteristica,a.desc_subUn sub,a.descripcion,a.umbralDesc,a.formula1 
								from Indicadores a,Unidades b, Rel_cargoIndicadores c, rel_indicadorUnidades e,
								Caracteristicas f '.
								"WHERE c.rut_res='$rut_res'
								AND a.idIndicador=c.fk_idIndicador
								AND f.idCaracteristica=a.fk_idCaracteristica
								AND b.idUnidad=e.fk_idUnidad 
								AND e.fk_idIndicador = a.idIndicador
								order by unidad asc");
		//$this->db->last_query();

		if ($sql->num_rows() >0) {
			return $sql->result_array();
		}else{
			return null;
		}
	}

	//UPD REL_CARGOINDICADOR
	public function updateRelCagoIndicador($rut_res,$idIndicador){
		$sql = $this->db->query("update Rel_cargoIndicadores set rut_res= '$rut_res' where fk_idIndicador= '$idIndicador'");
		return ($this->db->affected_rows() != 1) ? false : true;
	}

}





