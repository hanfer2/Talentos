<?php
  /**
  * Se incluye el archivo TGrupo.inc
  */
  require_once 'TGrupo.inc';

  /**
   * Clase TPrograma extendida de TBase
   *
   * Esta clase agrupa las funciones propias de un programa del Plan Talentos.
   */
  class TPrograma extends TBase {
		
		function __construct(){
			parent::__construct();
			$this->tablename = Config::Get(__CLASS__);
		}

    /**
     * Devuelve el nombre del programa segun el codigo del mismo
     *
     * @param int $cod_programa
     * @return array
     */
    function nombre($cod_programa) {
      if ($cod_programa == '0')
        return 'TODOS';
      return TPrograma::get($cod_programa, "nombre");
    }

    /**
     * Devuelve el resultado de una consulta con algunos los campos
     *
     * @param int $cod_programa
     * @param array $fields
     * @param array $options
     * @return array
     */
    function get($cod_programa, $fields='*', $options=array()) {
      return parent::get(__CLASS__, array('codigo' => $cod_programa), $fields, $options);
    }

    /**
     * Limita la consulta al primer resultado encontrado
     *
     * @param array $conditions
     * @return array
     */
    function first($conditions = array()) {
      return parent::first(__CLASS__, $options);
    }

    /**
     * Devuelve el maximo valor de un campo especifico en una consulta
     *
     * @param string $select
     * @return array
     */
    function max($select=null) {
      return parent::max(__CLASS__, $select);
    }

    /**
     * Consulta todos los programas de acuerdo a los criterios ingresados
     *
     * @param array $options opciones de la consulta.
     * @return array listado de programas de acuerdo a los criterios ingresados.
     */
    function all($options=array()) {
      return parent::all(__CLASS__, $options);
    }

    /**
     * Genera una consulta SQL que permite llenar los tags SELECT (HTML) con los programas existentes
     *
     * @return string Consulta SQL que permite llenar los tags SELECT (HTML) con los programas existentes
     */
    function toSQL($options=array()) {
      $sql = 'SELECT codigo, nombre FROM '.Config::Get(__CLASS__);
      if(is_user_login(COD_TIPO_VISITANTE_1))
        $sql .= " WHERE codigo = '001'";
      $sql .= " ORDER BY codigo DESC";
      return $sql;
    }

    /**
     * Crea una consulta SQL con los egresados para el programa indicado.
     *
     * @param string $cod_programa codigo del programa a consultar
     * @return string sql
     */
    function _egresadosSQL($cod_programa) {
    	$args = array(
    		'persona'=>Config::get('TPersona'), 'egresado'=>Config::get('TEgresado'),
    		'estudiante_programa'=>Config::get('TEstudiante','TPrograma'),
				'estudiante_colegio'=>Config::get('TEstudiante','TColegio'),
				'ocupacion'=>Config::get('TEgresado','Trabajo'),
				'colegios'=>Config::get('TColegio'),
				);
    	$sql = sprintfn("
    		SELECT cod_interno, fullname, %(persona)s.direccion, cod_estud, %(persona)s.cedula,
               %(persona)s.telefono, tel_celular, email, email_2, genero, edad(fecha_nacimiento), cod_universidad,
							 %(colegios)s.nombre as nombre_colegio, ocupacion
        FROM %(egresado)s INNER JOIN %(persona)s USING (cod_interno)
						LEFT JOIN %(estudiante_colegio)s USING (cod_interno)
						LEFT JOIN %(colegios)s ON (lpad(cod_colegio, 6,'0') = %(colegios)s.codigo)
						LEFT OUTER JOIN %(ocupacion)s USING (cod_interno)
        WHERE cod_programa = '$cod_programa' ", $args);
    	return $sql;
    }

    /**
     * Lista los estudiantes egresados de un determinado programa.
     *
     * @param string $cod_programa codigo del programa a consultar
     * @return array listado de estudiantes egresados para el programa indicado
     */
    function egresados($cod_programa) {
      $sql = TPrograma::_egresadosSQL($cod_programa);
      return DB::table_query($sql);
    }

    /**
     * Lista los estudiantes egresados sin Ingreso a Educacion Superior.
     *
     * @param string $cod_programa codigo del programa a consultar.
     * @return array listado de estudiantes sin Ingreso a Educacion Superior.
     */
    function egresadosNoIES($cod_programa) {

      $sql = TPrograma::_egresadosSQL($cod_programa) . " AND cod_universidad IS NULL";
      return DB::table_query($sql);
    }

    /**
     * Listado de Egresados reportados Con Ingreso a la Educacion Superior
     *
     * @param string $cod_programa codigo del programa
     * @return array listado de Egresados reportados Con Ingreso a la Educacion Superior
     */
    function egresadosIES($cod_programa) {
    	$args = array(
    		'persona_tablename'=>Config::get('TPersona'),
    		'estudiante_programa'=>Config::get('TEstudiante','TUniversidad'),
    		'estudiante_colegio'=>Config::get('TEstudiante','TColegio'),
				'colegios'=>Config::get('TColegio'),
    		'IES'=>Config::get('TEgresado','TUniversidad')
    		);
      $sql = sprintfn(
        "SELECT cod_interno, cod_estud, fullname, %(persona_tablename)s.direccion, %(persona_tablename)s.cedula,
                nombre_ciudad, %(persona_tablename)s.telefono, tel_celular, email, email_2, genero, edad(fecha_nacimiento),
                nombre_universidad, nombre_carrera, %(estudiante_programa)s.*,
								%(colegios)s.nombre as nombre_colegio
          FROM %(IES)s INNER JOIN %(persona_tablename)s USING (cod_interno)
          	INNER JOIN  %(estudiante_programa)s USING (cod_interno)
						LEFT JOIN %(estudiante_colegio)s USING (cod_interno)
						LEFT JOIN %(colegios)s ON (lpad(cod_colegio, 6,'0') = %(colegios)s.codigo)
          WHERE cod_programa = '$cod_programa'", $args);
      return DB::table_query($sql);
    }

    

    /**
     * Registra un nuevo PNAT.
     *
     * @param array $data datos del nuevo PNAT
     */
    function add($data) {
      DB::query(sql_insert_from_array(Config::get(__CLASS__), $data));
    }

    /**
     * Devuelve un arreglo con la informacion de una consulta
     *
     * @param int $cod_programa
     * @return null|array
     */
    function cursos($cod_programa, $tipo = null){
    	$sql = TSubgrupo::toSQL($cod_programa, $tipo);
    	return DB::table_query($sql);
   	} 
    
    function tieneCursos($cod_programa){
      $sql = "SELECT 1 FROM a_grupos WHERE cod_programa = '$cod_programa' LIMIT 1";
      return $this->db->boolQuery($sql);
    }
    
    function tieneParticipantes($cod_programa){
      $sql = "SELECT 1 FROM v_estudiantes_programas WHERE cod_programa = '$cod_programa' LIMIT 1";
      return $this->db->boolQuery($sql);
    }
		/**
		 * Remueve de un codigo de programa especifico
		 *
		 * @param int $cod_programa
		 */
		function removerCursos($cod_programa){
			DB::query("DELETE FROM ".Config::get('TGrupo')." WHERE cod_programa = '$cod_programa'");
		}

		/**
		 * Devuelve los componentes de los diferentes cursos dentro de un programa especifico
		 *
		 * @param int $cod_programa
		 * @param int $semestre
		 * @return array
		 */
		function componentes($cod_programa, $semestre=null){
      require_once 'TComponente.inc';
      
			$tablename = TComponente::getTable();
			$componentes_grupos = TComponente::getTable('TGrupo');
			$grupos = Config::get('TGrupo');
      
			$sql = "SELECT DISTINCT c.codigo, c.nombre, semestre 
							FROM $tablename c INNER JOIN $componentes_grupos ON cod_componente = c.codigo
							WHERE cod_curso IN (SELECT codigo FROM $grupos WHERE cod_programa = '$cod_programa') ";
			if($semestre !== null)
        if(upper($semestre) == 'CURSOS_ESPECIALES'){
          $sql .= sprintf(" AND c.modalidad = '%s'", TCOMPONENTE_MODALIDAD_TF);
        }
        else{
          $sql .=" AND semestre = $semestre ";
        }
			$sql . "ORDER BY semestre ASC, cod_componente";
			return DB::table_query($sql);
		}
		
		function asignarComponente($cod_componente, $cod_programa, $semestre){
      $semestre = q($semestre);
      if($semestre == 3)
        return TPrograma::asignarComponentesACursosEspeciales($cod_componente, $cod_programa);
			$cod_programa = q($cod_programa);
			$cod_componente = q($cod_componente);
			
			$sql = 'INSERT INTO cu_componentes_cursos("codigo","cod_componente","semestre","cod_curso") '.
						 "SELECT  '$cod_componente'||cod_grupo||'$semestre' AS codigo, '$cod_componente', '$semestre', cod_grupo
						  FROM  ".Config::Get("TGrupo","viewname")." WHERE cod_programa = '$cod_programa' AND tipo IS NULL";
			DB::query($sql);
		}
    
    function asignarComponentesACursosEspeciales($cod_componente, $cod_programa)
    {
      $sql = 'INSERT INTO cu_componentes_cursos ("codigo","cod_componente","semestre","cod_curso") '
           .  "SELECT '$cod_componente'||cod_grupo||'3' AS codigo, '$cod_componente', '3' , cod_grupo "
           .  "FROM v_grupo g WHERE cod_programa = '$cod_programa' AND tipo = 'TF' AND NOT EXISTS "
           .  "(SELECT * FROM cu_componentes_cursos cc WHERE cc.cod_componente = '$cod_componente' AND cc.cod_curso = g.cod_grupo) ";
      DB::query($sql);
    }
		
		function removerComponente($cod_componente, $cod_programa, $semestre){
			$cod_programa = q($cod_programa);
			$semestre = q($semestre);
			$cod_componente = q($cod_componente);
			
			$sql = "DELETE FROM ".config::get('TComponente','TGrupo').
						 " WHERE cod_componente = '$cod_componente' AND semestre = '$semestre' AND cod_curso IN (
							SELECT codigo FROM ".Config::Get("TGrupo")." WHERE cod_programa = '$cod_programa')";
			DB::query($sql);
		}
		
		function fechas($cod_programa, $semestre=null){
			$fechas = null;
			if($semestre == null){
				$fechas['inicio'] = 'fecha_inicio_1';
				$fechas['cierre'] = 'fecha_cierre_2';
			}else{
        if($semestre > 2)
          $semestre = 2;
				$fechas['inicio'] = 'fecha_inicio_'.$semestre;
				$fechas['cierre'] = 'fecha_cierre_'.$semestre;
			}
			return TPrograma::get($cod_programa, "{$fechas['inicio']} AS inicio, {$fechas['cierre']} AS cierre");
		}
		
		/**
		 * Refiere al programa actual.
		 * TODO: En el momento selecciona el ultimo. Debe corregirse
		 */
		function actual(){
			$cod_programa = Config::get('App','CU.COD_PROGRAMA_ACTUAL');
			return $cod_programa;
		}
		
		function esta_activo($cod_programa){
			$sql = "SELECT 1 FROM {$this->tablename} where codigo = '$cod_programa' and CURRENT_DATE >= fecha_inicio_1 AND CURRENT_DATE < fecha_cierre_2";
			return $this->db->boolQuery($sql);
		}
    
    
    function getObject($cod_programa){
      $sql = "SELECT * FROM a_programas WHERE codigo = '$cod_programa'";
      $this->db->consulta($sql);
      return $this->db->fetch_object();
    }
    
    function isClosed($cod_programa){
      $sql = "SELECT 1 FROM a_programas p WHERE codigo = '$cod_programa' AND (p.fecha_cierre_2 > CURRENT_DATE OR EXISTS (SELECT * FROM v_estudiantes_programas v WHERE v.cod_programa = p.codigo AND cod_estado = '".COD_ESTADO_ACTIVO."' LIMIT 1) )";
      return ! $this->db->boolQuery($sql);
    }
    
    function close($cod_programa){
      $user = &AppContext::getUser();
      $sql = sprintf("UPDATE a_persona SET cod_estado = '%s', updated_by = '%s' WHERE cod_tipo_per = '%s' AND cod_estado = '%s' AND cod_interno IN (SELECT cod_interno FROM v_estudiantes_programas WHERE cod_programa = '%s')", COD_ESTADO_EGRESADO, $user->getRoleId(),COD_TIPO_ESTUDIANTE, COD_ESTADO_ACTIVO, $cod_programa);
      $this->db->query($sql);
      $sql = sprintf("UPDATE a_programas SET fecha_cierre_2 = CURRENT_DATE WHERE codigo = '%s' AND fecha_cierre_2 > CURRENT_DATE", $cod_programa);
      $this->db->query($sql);
    }
  }

?>
