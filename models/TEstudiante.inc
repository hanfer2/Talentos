<?php
  require_once 'TPersona.inc';
  require_once 'TIcfes.inc' ;
  require_once 'TPrograma.inc';
  require_once 'TUniversidad.inc';

   class TEstudiante extends TPersona {
		 
		 function __construct(){
			 parent::__construct();
			 $this->tablename = $this->Config->get(__CLASS__);
		 }

    function cod_interno($cedula, $estado = null) {
			if(is_array($cedula) && isset($cedula['cod_interno'])){
				return $cedula['cod_interno'];
      }
      $sql = sprintf("SELECT cod_interno FROM v_estudiantes where cedula='%s'", q($cedula));
      if($estado != null)
        $sql .= " AND cod_estado = $estado";
      return DB::fetchOne($sql);
    }

    function all($options=array()){
    	return TBase::all('TPersona', $options);
    }
    
    function activos($options=array()){
    	$options = array_merge((array) $options, array('conditions'=>array('cod_tipo_per'=>COD_TIPO_ESTUDIANTE, 'pr.cod_estado'=>COD_ESTADO_ACTIVO)));
			if(array_key_exists('cod_programa', $options)){
				$options['join'] =  Config::get(__CLASS__, 'TGrupo') . " pr USING (cod_interno) ";
				$options['conditions']['cod_programa'] = $options['cod_programa'];
			}
    	return TEstudiante::all($options);
    }
    
    function exists($cedula){
			$sql = "SELECT 1 FROM ".Config::get('TPersona')." WHERE cedula = '$cedula' AND cod_tipo_per = '".COD_TIPO_ESTUDIANTE."'";
			$r = DB::query($sql);
			return $r != null;
		}
    
    function nombre($cedula, $separator = ', ') {
      return DB::query(sprintf("SELECT apellidos ||'$separator' ||nombres FROM %s where cedula='%s'", Config::get(__CLASS__, 'viewname'),q($cedula)));
    }
    
    function colegio($cedula, $options= array()){
    	$cod_interno = TPersona::cod_interno($cedula);
    	if($cod_interno == null)
    		return FALSE;
    	if(!isset($options['select']))
    		$options['select'] = 'codigo, nombre, tipo';
    	$sql = "SELECT {$options['select']} FROM ". Config::get('TColegio') . 
    				 " WHERE codigo = (SELECT cod_colegio FROM ".Config::get("TEstudiante","TColegio").
    				 " WHERE cod_interno = '$cod_interno')";
    	return DB::query($sql);
    }

    function curso($cedula, $tipo = null, $fields='cod_grupo, nombre_grupo') {
			$cod_interno = TPersona::cod_interno($cedula);
      $sql = sprintf("SELECT %s FROM a_estudiantes_grupos JOIN v_grupo USING (cod_grupo) WHERE cod_interno = '%s' AND tipo %s", $fields, $cod_interno, is_blank($tipo) ? 'IS NULL': " = '$tipo'");
      
      return DB::query($sql);
    }
    
    function curso_y_grupo($cedula){
      return TEstudiante::curso($cedula, null, "grupo, cod_grupo");
    }

    function icfes($cod_interno, $prueba=null) {
      $db = &DB::instance();
      $sql = "SELECT * FROM a_estudiantes_icfes WHERE cod_interno = '$cod_interno' ";
      if(!is_null($prueba))
        $sql.=" AND tipo = $prueba";
      return $db->fetch_array($sql, true);
    }
    
   function cedulas_presentaron_icfes_x_subgrupo($curso, $prueba){
     
  $sql="select cedula from a_persona where cod_interno IN (
select cod_interno from a_estudiantes_grupos where cod_grupo='$curso' and cod_interno IN
(select cod_interno from i_cuestionarios_diligenciados where cod_prueba='$prueba') )";   

return DB::query($sql);
  }
    

    function horario($cedula){
    	$cod_curso = TEstudiante::curso($cedula, null, 'cod_grupo');
    	return TSubgrupo::horarioSemanal($cod_curso);
    }
    
    function clases($cedula){
    	$cod_curso = TEstudiante::curso($cedula, null, 'cod_grupo');
    	return TSubgrupo::horario($cod_curso);    	
    }

    /**
     * Permite cancelar los curso de un estudiante.
     * @param int $cod_interno codigo interno del estudiante
     * @param int $cod_periodo codigo del periodo
     * @param string $fecha_cancelacion fecha de cancelacion a registrar
     * @return bool TRUE si fue exitosa el proceso, de lo contrario FALSE
     */
    function cancelar_cursos($cod_interno, $cod_periodo=null, $fecha_cancelacion=null) {
      $db = &DB::instance();
      $cod_periodo = any($cod_periodo, TPeriodo::actual());
      $fecha_cancelacion = any($fecha_cancelacion, date("Y-m-d"));
      $sql = "UPDATE a_estud_curso SET fecha_cancelado = '$fecha_cancelacion' where cod_interno = $cod_interno and cod_periodo = $cod_periodo";
      $db->consulta($sql);
      return TRUE;
    }

    /**
     * Cambia el estado de un estudiante a INACTIVO (12).
     * @param int $cod_interno codigo interno del estudiante a inactivar.
     */
    function inactivar($data) {
      $db = &DB::instance();
      $hechoPor = AppContext::getUserId();
			$sql = "UPDATE a_persona set cod_estado = ".COD_ESTADO_INACTIVO." where cod_interno = '{$data['cod_interno']}'";
      $db->consulta($sql);
			$bloqueado = array('cod_interno'=>$data['cod_interno'], 'motivo'=>$data['causa_bloqueo'], 'updated_by'=>$hechoPor, 'authorized_by'=>$data['authorized_by']);
			$sql = sql_insert_from_array(Config::get(__CLASS__,'Bloqueados'),$bloqueado);
			$db->consulta($sql);
      return TRUE;
    }
    
    function reactivar($cedula){
    	$cod_interno = TPersona::cod_interno($cedula);
    	$db = &DB::instance();
    	$sql = "UPDATE a_persona set cod_estado = ".COD_ESTADO_ACTIVO." where cod_interno = '$cod_interno'";
    	$db->consulta($sql);
    	$sql = "DELETE FROM ". Config::get(__CLASS__,'Bloqueados'). " WHERE cod_interno = '$cod_interno'";
    	$db->consulta($sql);
    	return TRUE;
    }

		function causas_bloqueo() {
		 return DB::query("select * FROM ".Config::get(__CLASS__,'CausaBloqueo'));
		}

		function cursosACambiar($cedula){
			$curso = DB::query("SELECT * FROM ".Config::get('TGrupo','viewname')." WHERE cod_grupo = (SELECT cod_grupo FROM ".Config::get('TEstudiante','TGrupo')." WHERE cedula = '$cedula')");
			if(!$curso)
				return false;
			$sql = "
				SELECT cod_grupo AS codigo, nombre_grupo AS nombre
				FROM ".Config::get('TGrupo','viewname')." WHERE cod_grupo <> {$curso['cod_grupo']}
					AND cod_programa = '{$curso['cod_programa']}' AND tipo IS NULL ";
			return DB::query($sql);
		}

		function cambiarCurso($cod_interno, $nuevoCurso){
			$updated_by = TPersona::cod_interno(user_logged_info('cedula'));
			DB::query("UPDATE ".Config::get(__CLASS__, 'TCurso')." SET cod_grupo = '$nuevoCurso', fecha_ingreso = now(), updated_by = '$updated_by' WHERE cod_interno = '$cod_interno'");
		}
		
		function asignarCurso($cod_interno, $cod_curso){
			$sql = sql_insert_from_array(Config::get(__CLASS__, 'TCurso'), array('cod_interno'=>$cod_interno, 'cod_grupo'=>$cod_curso));
			DB::query($sql);
		}
		
		
		function flotantes(){
			return  array('93101528497','1130683745','1107054716','1143843173');
		}
		
		
		function flotantes_actuales($cod_programa){
			$sql = "SELECT cod_interno FROM ".Config::Get(__CLASS__, 'flotantes') ." WHERE flota IS TRUE AND cod_interno IN (SELECT cod_interno FROM ".Config::Get(__CLASS__, 'TPrograma')." WHERE cod_programa = '".q($cod_programa)."')";
			DB::aquery();
		}
		function listadoEnEmbarazo($options){
			if(!isset($options['select']))
				$options['select'] = "*";
			$sql = "SELECT ${options['select']}  FROM ".
							Config::Get('TPersona','Embarazo')." INNER JOIN " .Config::get('TPersona')." persona USING (cod_interno) ".
						 "INNER JOIN ".Config::Get(__CLASS__, 'TGrupo'). " USING (cod_interno) ".
						 "WHERE cod_programa = '{$options['cod_programa']}'";
			return DB::table_query($sql);
		}
		
		function desplazados($options){
			if(!isset($options['select']))
				$options['select'] = "*";
			$sql = "SELECT  ${options['select']}  FROM ".
							Config::Get('TPersona','Desplazado')." desplazados INNER JOIN " .Config::get('TPersona')." persona USING (cod_interno) ".
						 "INNER JOIN ".Config::Get(__CLASS__, 'TGrupo'). " USING (cod_interno) ".
						 "INNER JOIN ".Config::Get('TCiudad'). " ciudades ON desplazados.cod_ciudad = ciudades.codigo ".
						 "WHERE cod_programa = '{$options['cod_programa']}'";
			return DB::table_query($sql, $options['group_by']);			
		}
		
		function inactivos($cod_programa, $options=array()){
			$sql = "SELECT * FROM ". Config::get(__CLASS__, 'Inactivos') .
						 " WHERE cod_programa = '$cod_programa'";
			return DB::table_query($sql);
		}
		
		/**
		 * Retorna el listado completo de participantes de un programa, dependiendo del status
		 * @param string $cod_programa codigo del programa al que participante debe pertenecer
		 * @param string $status codigos de los estados (separados por comas) en el que el participante puede estar. Ej: 11,13
		 * @return array listado de los participantes.
		 * 	- Campos a mostrar:  Cedula, Cod_Estud, Apellidos, Nombres, Fullname, Telefono, Celular, Email, Email_2, 
		 * 											 Comuna, Edad, Nombre_Estado, Nombre_Grupo, Cod_grupo
		 */
		function listado_completo($cod_programa, $status){
			$cod_programa = q($cod_programa);
			if(is_blank($cod_programa) || is_blank($status))
				return null;
			$sql = "SELECT v.cedula, cod_estud, apellidos, nombres, fullname, telefono, tel_celular, direccion, email, email_2,".
								"comuna, edad(fecha_nacimiento) AS edad, Estado.nombre as nombre_estado, nombre_grupo, cod_grupo ".
						 "FROM ".$this->Config->Get('TEstudiante','TGrupo'). " v JOIN ".$this->Config->Get("TEstado") ." Estado ON (Estado.codigo = v.cod_estado) ".
								" JOIN ". $this->Config->Get('TPersona') . " p using (cod_interno) ".
						 "WHERE cod_programa = '$cod_programa' AND v.cod_estado IN ($status) ".
						 "ORDER BY fullname";
			return $this->db->table_query($sql);
		}
		
		
		function egresados($cod_programa){
			$tablenames = array();
			$tablenames['TPersona'] = $this->Config->Get('TPersona');
			$tablenames['TEgresado'] = $this->Config->Get('TEgresado');
			$tablenames['TEstudianteGrupo'] = $this->Config->Get(__CLASS__, 'TGrupo');
			
			$sql = "SELECT * FROM ".$tablenames['TPersona'] ." p JOIN " . $tablenames['TEstudianteGrupo'] . " USING (cod_interno) ".
						 "WHERE cod_programa = '$cod_programa' AND p.cod_estado = '".COD_ESTADO_EGRESADO."'";
						 
			return $this->db->table_query($sql);
		}
    

  }
  
  require_once 'TMotivoInasistencia.inc';
?>
