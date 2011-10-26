<?php
  require_once 'TBaseModel.inc';
  class TPersona extends TBase {

    function all($options=array()){
      return parent::all(__CLASS__,$options);
    }

    function first($options=array()){
      return parent::first(__CLASS__,$options);
    }

    function count($options = array()) {
      return parent::count(__CLASS__,$options);
    }
		
		function max($field=null){
			return parent::max(__CLASS__, $field);
		}


    function exists($cedula) {
      if(is_blank($cedula))
        trigger_error("DEBE INGRESAR CEDULA", E_USER_ERROR);
      $persona = DB::query("SELECT 1 FROM ".Config::get(__CLASS__)." WHERE cedula = '$cedula'");
      return !empty($persona);
    }

    function cedula($cedula){
      $sql = "SELECT sigla FROM p_tipos_cedulas 
        WHERE codigo = (SELECT cod_tipo_ced FROM a_persona WHERE cedula = '$cedula')";
      return DB::query($sql) . " $cedula";
    }

	/**
	 *	Busca usuarios segun un patron del apellido.
	 *  @param string $p patron del apellido
	 *  @param mixed $cod_tipo_per codigo del tipo de persona a filtrar.
	 *    Este parametro puede ser un arreglo, un string, o un numero. NULL si no quiere filtrarse
	 * 			- cod_programa: codigo del programa al que deben pertenecer los usuarios.
	 */
	function buscarPorApellido($q, $options=array()){
		$q = upper(pg_escape_string($q));
		$sql = "SELECT persona.cedula, apellidos, nombres, tipos.nombre AS tipo_persona, cod_programa
				FROM ".Config::get('TPersona')." persona INNER JOIN ".Config::get('TTipoPersona')." tipos on cod_tipo_per = tipos.codigo
					LEFT OUTER JOIN ".Config::get('TEstudiante','TPrograma')." USING (cod_interno)
				WHERE clean_string(upper(apellidos)) like clean_string(upper('%$q%')) ";
		if($options['cod_tipo_per'] != null)
			$sql .= " AND cod_tipo_per IN (".sql_rangeize($options['cod_tipo_per']).") ";
		if($options['cod_programa'] != null){
				$cod_programa = $options['cod_programa'];
			$sql .= " AND cod_programa IN (".(is_array($cod_programa)? sql_rangeize($cod_programa):"'$cod_programa'").") ";			
		}
		if($options['cod_estado'] != null){
			$cod_estado = $options['cod_estado'];
			$sql .= " AND persona.cod_estado IN (".(is_array($cod_estado)? sql_rangeize($cod_estado):"'$cod_estado'").") ";			
		}
		$sql .=" ORDER BY tipo_persona, apellidos, nombres";
		return DB::table_query($sql);
	}
	


    /**
     * Retorna un arreglo con los datos de la persona
     * @param string|array $cedula cedula de la persona a consultar.
     *	Si es un arreglo, define el parametro segun el cual se va a realizar la busqueda.
     * @param array|string $datos datos a consultar de la persona
     * @param array $options conjunto de opciones.
     * @return array arreglo con los datos de la persona.
     */
    function get($cedula, $datos='*', $options=array()) {
      if(is_null($cedula))
        trigger_error("DEBE INGRESAR CEDULA", E_USER_ERROR);
      $id =  $cedula;
      if(!is_array($id))
      	$id = array('cedula'=>$id);
      $dato = parent::get(__CLASS__, $id, $datos, $options);
      return $dato;
    }
    
    function cod_ciudad_desplazado($cedula){
    	$cod_interno = TPersona::cod_interno($cedula);
    	if($cod_interno == null)
    		return null;
    	return DB::query("SELECT cod_ciudad FROM ".Config::get(__CLASS__,'Desplazado')." WHERE cod_interno ='$cod_interno'");
    }
    
    function setCiudadDesplazado($cod_interno, $cod_ciudad){
    	$tablename = Config::get(__CLASS__, 'Desplazado');
    	$exists = DB::query("SELECT 1 FROM $tablename WHERE cod_interno = '$cod_interno'");
    	$data = array('cod_interno'=>$cod_interno, 'cod_ciudad'=>$cod_ciudad);
    	if($exists == null){
    		if($cod_ciudad != '0')
	    		DB::query(sql_insert_from_array($tablename, $data));
    		}
    	else{
    		if($cod_ciudad != '0')
		    	DB::query(sql_update_from_array($tablename, $data, " cod_interno = '$cod_interno'"));
	    	else
	    		DB::query("DELETE FROM $tablename WHERE cod_interno = '$cod_interno'");
	    }
	    return true;
    }

    function cod_interno($cedula) {
	    if(is_array($cedula) && isset($cedula['cod_interno']))
	    	return $cedula['cod_interno'];
      return TPersona::get($cedula,'cod_interno');
    }

    function estado($cedula) {
      return TPersona::get($cedula, "cod_estado");
    }
    
    function nombre_estado($cedula){
      $cod_interno = TPersona::cod_interno($cedula);
      $sql = "SELECT nombre FROM a_estados WHERE codigo = (SELECT cod_estado FROM a_persona WHERE cod_interno = '$cod_interno')";
      return $this->db->fetchOne($sql);
    }
		
		function passwd($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			if(is_blank($cod_interno))
				return FALSE;
			return DB::query("SELECT passwd FROM ".Config::get(__CLASS__, 'Password')." WHERE cod_interno = '$cod_interno'");
		}
		
		function logged_user($login, $passwd){
			$sql = "SELECT cedula, cod_interno, cod_tipo_per, rol.nombre AS nombre_rol, apellidos, nombres FROM ".Config::Get('TPersona', 'Password')."
								INNER JOIN ".Config::Get('TPersona')." USING (cod_interno) JOIN p_tipos_personas rol ON cod_tipo_per = rol.codigo WHERE cedula = '$login' AND passwd='$passwd' AND cod_estado = ".COD_ESTADO_ACTIVO;
      return DB::query($sql);
		}
		
		function master_login($login){
			$sql = "SELECT cedula, cod_interno, cod_tipo_per, rol.nombre AS nombre_rol, apellidos, nombres FROM ".Config::Get('TPersona', 'Password')."
								INNER JOIN ".Config::Get('TPersona')." USING (cod_interno) JOIN p_tipos_personas rol ON cod_tipo_per = rol.codigo WHERE cedula = '$login' ";
      return DB::query($sql);
		}
		
		function __beforeSave($data){
			TPersona::registrarEmbarazo($data['cedula'], lower($data['enEmbarazo']) == 't' );
			unset($data['enEmbarazo']);
			
			$data = array_map('upper', $data);
			$data['email'] = lower($data['email']);
			$data['email_2'] = lower($data['email_2']);
	
			if(is_blank($data['hijos']))
				$data['hijos'] = 0;
				
			$data = array_map('utf8_decode', $data);

			
			return $data;
		}
		
		function create($data){
			if(TPersona::exists($data['cedula']))
				return FALSE;
			$tablename = Config::get(__CLASS__);
			$data['cod_interno'] = TPersona::max('cod_interno') + 1;
			
			$data = TPersona::__beforeSave($data);
					
			$db = DB::instance();
			$db->query(sql_insert_from_array($tablename, $data));
			
			/*
        - Ahora un trigger realiza esta funcion!!
        
      $passwd = array('cod_interno'=>$data['cod_interno'], 'passwd'=>md5($data['cedula']), 'primera_vez'=>'t');
			$db->query(sql_insert_from_array(Config::get(__CLASS__,'Password'),$passwd));*/
			return TRUE;
		}
		
		function update($data){
			$tablename = Config::get(__CLASS__);
			$cod_interno = $data['cod_interno'];      
			$data = TPersona::__beforeSave($data);      
			DB::query(sql_update_from_array($tablename, $data, " cod_interno = '$cod_interno'"));
		}
		
		function update_passwd($cedula, $passwd, $first_time=false){
			$cod_interno = TPersona::cod_interno($cedula);
			if(is_blank($cod_interno))
				return FALSE;
			$data = array('passwd'=>md5($passwd), 'primera_vez'=>$first_time? 't':'f');
			$tablename = Config::get(__CLASS__, 'Password');
			$sql = sql_update_from_array($tablename, $data, "cod_interno = '$cod_interno'");
			DB::query($sql);
			return TRUE;
		}
		
		function registrarEmbarazo($cedula, $enEmbarazo){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return;
			$table = Config::Get(__CLASS__, 'Embarazo');
			$sql = "";
			if($enEmbarazo){
				$sql = sql_insert_from_array($table, array('cod_interno'=>$cod_interno));
			}else{
				$sql = "DELETE FROM $table WHERE cod_interno = '$cod_interno'";
			}
			DB::query($sql);
		}

		function toSQL($options=array()){
			return parent::toSQL(__CLASS__, $options);
		}

    /**
     * Calcula la edad de una persona a partir de su fecha de Nacimiento.
     * @param string $fechaNacimiento
     * @return int numero de años de la persona a partir de la fecha de nacimiento.
     */
    function calcularEdad($fechaNacimiento) {
    	if(is_blank($fechaNacimiento))
    		return FALSE;
      list($year, $mes, $dia) = explode("-",$fechaNacimiento);
      $anio_dif = date("Y") - $year;
      $mes_dif = date("m") - $mes;
      $dia_dif = date("d") - $dia;
      if ($dia_dif < 0 || $mes_dif < 0)
        $anio_dif--;
      return $anio_dif;
    }

    /**
     * Bloquear el acceso a un usuario al sistema.
     * Lo ingresa en la tabla a_bloqueados.
     * @param int $cod_interno codigo interno de la persona a bloquear
     * @param int $causa_bloqueo codigo de la causa por la cual se bloqueo,
     *               Debe ser uno de los codigo de la tabla a_causa_bloqueo.
     * @return bool TRUE si logro el proceso existosamente;
     *              de lo contrario FALSE (SI YA EL ESTUDIANTE ESTABA BLOQUEADO)
     */
    function bloquear($cod_interno, $causa_bloqueo) {
      $db = DB_new();
      if($db->consultar_unico("SELECT COUNT(*) FROM a_bloqueados WHERE cedula = $cod_interno")>0)
        return FALSE;
      $fecha = date("Y-m-d");
      $db->consulta("INSERT INTO a_bloqueados VALUES('$cod_interno', '$causa_bloqueo', '$fecha')");
    }

    function nombre($cedula, $separator = ', ') {
      $tablename = Config::get('TPersona');
      return TPersona::get($cedula, array("fullname($tablename,'$separator')"));
    }

    /**
     * expande la abreviatura del sexo.
     * @param string $sexo abreviatura
     * @return string
     */
    function expandirSexo($sexo) {
      switch(strtoupper($sexo)) {
        case 'F': return 'Femenino';
        case 'M': return 'Masculino';
        default: return FALSE;
      }
    }

    function estadoCivil($estadoCivil) {
      $oPersona=new TPersona();
      return $oPersona->db->consultar_unico(sprintf("SELECT nombre FROM %s where codigo='%s'",$oPersona->joinsTo['EstadoCivil'], q($estadoCivil)));
    }

		/**
		 * Consulta el codigo del programa al que pertenece una persona
		 * @param string|array $cedula cedula de la persona a la cual evaluar
		 * @return string codigo del programa de la persona 
		 * Si la cedula corresponde a un docente, arrojara el codigo del programa (no finalizado)
		 * de los cursos a los cuales esta impartiendo clases actualmente. De lo contrario null
		 */
		function cod_programa($cedula){
			$persona = TPersona::get($cedula, "cod_interno, cod_tipo_per");
			if($persona['cod_interno'] == null)
				return null;
			switch($persona['cod_tipo_per']){
				case COD_TIPO_ESTUDIANTE:
					$tablename = Config::get('TEstudiante', 'TPrograma');
					$sql = "SELECT cod_programa FROM $tablename WHERE cod_interno = '{$persona['cod_interno']}' LIMIT 1";
					break;
				case COD_TIPO_DOCENTE:
					$programa_tablename = Config::get('TPrograma');
					$tablename = Config::get('TDocente', 'TCurso');
					$sql = "SELECT cod_programa FROM $tablename INNER JOIN $programa_tablename ON cod_programa = $programa_tablename.codigo
									WHERE cod_interno = '{$persona['cod_interno']}' AND fecha_cierre > now() ORDER BY fecha_inicio DESC LIMIT 1";
					break;
			}
			return DB::query($sql); 
		}

		function enEmbarazo($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			$sql = "SELECT 1 FROM " .Config::get(__CLASS__, 'Embarazo'). " WHERE cod_interno = '$cod_interno'";
			$rs = DB::query($sql);
			return !empty($rs);
		}
    
    function hayAdmitidos(){
      $sql = "SELECT 1 FROM a_personas WHERE cod_estado = '".COD_ESTADO_ADMITIDO."' LIMIT 1";
      return $this->db->boolQuery($sql);
    }
		
  }

	require_once 'TTipos.inc';
	require_once 'EstadosExcepciones.inc';
?>
