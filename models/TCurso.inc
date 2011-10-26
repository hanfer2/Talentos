<?php

      /**
       * Se incluye el archivo TPrograma.inc
       */
	require_once 'TPrograma.inc';

  /**
   * Clase TSubgrupo extendida de TBase
   */
	class TSubgrupo extends TBase {
    
    function __construct(){
      parent::__construct();
      $this->tablename = $this->Config->get('TGrupo');
    }

		/**
		 * Deuvel si exite o no un grupo dentro de un programa especifico
		 *
		 * @param string $grupo
		 * @param string $subgrupo
		 * @param int $cod_programa
		 * @param string $modificador
		 * @return boolean
		 */
		function exists($grupo, $subgrupo, $cod_programa, $modificador) {

			$grupo = TGrupo::all(array('conditions' => array('grupo' => $grupo,
						'subgrupo' => $subgrupo, 'cod_programa' => $cod_programa,
						'tipo' => ($modificador == '-') ? null : $modificador)));
			return!empty($grupo);
		}

    /**
     * Crea un nuevo subgrupo
     *
     * @param array $valores
     */
		function crear($valores) {
			if (is_blank($valores['codigo'])) {
				$cod_grupo = TSubgrupo::max();
				$valores['codigo'] = $cod_grupo + 1;
			}
			$sql = sql_insert_from_array('a_grupos', $valores);
			DB::query($sql);
		}

    /**
     * Devuelve la informacion del grupo especificado
     *
     * @param int $codigo
     * @param array $fields
     * @param array $options
     * @return array
     */
		function get($codigo, $fields='*', $options=array()) {
			$options['from'] = Config::get('TGrupo', 'viewname');
			return parent::get('TGrupo', array('cod_grupo' => $codigo), $fields, $options);
		}

    /**
     * Devuelve la cantidad de estudiantes activos por grupo
     *
     * @param array $options
     * @return array
     */
		function all($options=array()) {
			if (is_array($options['conditions']) && $options['conditions']['tipo'] == '-')
				$options['conditions']['tipo'] = null;
        
			if($options['cantidad_estudiantes']){
				$options['select'] = "*, cantidad_estudiantes";
				$options['join'] = " (SELECT cod_grupo, count(*) AS cantidad_estudiantes".
													 " FROM ".Config::get('TEstudiante','TGrupo').
													 " WHERE cod_estado = ".COD_ESTADO_ACTIVO.
													 " GROUP BY cod_grupo) TCounter ON (cod_grupo = codigo)";
			}
			return parent::all('TGrupo', $options);
		}
    /**
     * Listado de los Cursos asociados a un programa
     * @param string $cod_programa codigo del programa.
     * @param int $cod_estado codigo del estado de los estudiantes a filtrar.
     * @param string $cod_grupo letra del grupo (A, B, C, D... ). 
     *  De no especificarse se listaran los cursos de todos los grupos 
     * @return array listado de los cursos.
     */
    
    function listado($cod_programa, $cod_estado, $cod_grupo=null){
       
      $tableEstudiantesGrupos = $this->Config->get("TEstudiante","TGrupo");
      
      $sql = " SELECT codigo, grupo, subgrupo, cupos, cantidad_estudiantes ".
             " FROM {$this->tablename} LEFT JOIN (SELECT cod_grupo, count(*) AS cantidad_estudiantes FROM $tableEstudiantesGrupos WHERE cod_estado = $cod_estado GROUP BY cod_grupo) TCounter ON (cod_grupo = codigo) ".
             " WHERE cod_programa = '$cod_programa' ";
      if($cod_grupo != null)
        $sql .=" AND grupo = '$cod_grupo' ";
      $sql .=" AND tipo IS NULL ORDER BY tipo desc, grupo, subgrupo ";
             
      return $this->db->table_query($sql);
    }


		/**
		 * Consulta el grupo (letra) al que pertenece un curso.
                 *
		 * @param int|string $cod_curso curso a consultar.
		 * @return string grupo (letra) al que pertenece un grupo.
		 */
		function grupo($cod_curso) {
			if (is_blank($cod_curso))
				return FALSE;
			if ($cod_curso == 0 || $cod_curso == '-')
				return "TODOS";
			return TSubgrupo::get($cod_curso, 'grupo');
		}

		/**
		 * Consulta el nombre de un curso.
                 *
		 * @param int|string $cod_curso codigo del curso a consultar.
		 * @return string nombre del curso.
		 */
		function nombre($cod_curso) {
			if ($cod_curso == 0)
				return "TODOS";
			return TSubgrupo::get($cod_curso, 'nombre_grupo');
		}

		/**
		 * Consulta el codigo del programa al que pertenece un grupo dado.
                 *
		 * @param string|int $cod_curso codigo del curso a consultar
		 * @return string codigo del programa del curso.
		 */
		function programa($cod_curso) {
			return TSubgrupo::get($cod_curso, 'cod_programa');
		}

		/**
		 * Devuelve el valor maximo del campo a consultar
                 *
		 * @param string $field nombre del campo a consultar. Por defecto es la llave primaria
		 * @return int numero maximo del campo a consultar
		 */
		function max($field='codigo') {
			return parent::max('TGrupo', $field);
		}

                /**
                 * Devuelve los nombre completos de los tipos
                 *
                 * @return array
                 */
		function tipos() {
			return array('-' => 'Académicos', 'TF' => 'Talleres Formativos');
		}

                /**
                 * Devuelve el nombre del tipo
                 *
                 * @param string $modificador
                 * @return string
                 */
		function nombre_tipo($modificador) {
			$tipos = TSubgrupo::tipos();
			if (in_array($modificador, array_keys($tipos)))
				return $tipos[$modificador];
			return 'Académicos';
		}
    
    	/**
		 * Lista los estudiantes inscritos en un curso
                 *
		 * @param int codigo del grupo
		 * @return array arreglo de estudiantes inscritos en el grupo indicado.
		 * 				Se muestra: cod_interno, cod_programa, nombres, apellidos, cedula
		 */
		function _inscritosSQL($cod_curso, $conditions=null) {

      $table_EstudiantesGrupos = $this->Config->get('TEstudiante', 'TGrupo');
      $table_Estudiantes  = $this->Config->get('TEstudiante');
      
      $sql = " SELECT cod_interno, e.cedula, fullname, grupo, nombre_grupo, cod_grupo ".
             " FROM $table_EstudiantesGrupos eg INNER JOIN $table_Estudiantes e USING (cod_interno)  ";
             
			if ($cod_curso != 0)
        $conditions[] = "cod_grupo = '$cod_curso'";
      if(count($conditions) > 0)
        $sql .= " WHERE ". implode(" AND ", $conditions);

			return $sql;
		}
    
    /**
		 * Lista los estudiantes inscritos en un curso
     *
		 * @param int codigo del grupo
		 * @return array arreglo de estudiantes inscritos en el grupo indicado.
		 * 				Se muestra: cod_interno, cod_programa, nombres, apellidos, cedula
		 */
		function inscritos($cod_curso, $options= array()) {
			$sql = $this->_inscritosSQL($cod_curso);
			$sql .= "  ORDER BY apellidos";
			return DB::query($sql);
		}

		/**
		 * Lista los estudiantes inscritos en un curso
                 *
		 * @param int codigo del grupo
		 * @return array arreglo de estudiantes inscritos en el grupo indicado.
		 * 				Se muestra: cod_interno, cod_programa, nombres, apellidos, cedula
		 */
		function inscritosActivos($cod_curso, $options= array()) {
			$sql = $this->_inscritosSQL($cod_curso, array_merge((array)$options,array(" e.cod_estado = ".COD_ESTADO_ACTIVO)));
      
			$sql .= "  ORDER BY apellidos";
      
      //echo $sql;
      
			return DB::query($sql);
		}
    
    function inscritosEgresados($cod_curso, $options=array()){
      $sql = $this->_inscritosSQL($cod_curso, array(" e.cod_estado = ".COD_ESTADO_EGRESADO));
			$sql .= "  ORDER BY apellidos";
			return DB::query($sql);
    }

		/**
		 * Indica si un estudiante pertenece a un curso.
                 *
		 * @param int|string $cod_curso codigo del curso a consultar.
		 * @param string $cedula cedula del estudiante a consultar
		 * @return bool TRUE si el curso contiene al estudiante, de lo contrario, FALSE.
		 */
		function contieneA($cod_curso, $cedula) {
			$cod_interno = TPersona::cod_interno($cedula);
			if (empty($cod_interno))
				return FALSE;
			$oGrupo = new TGrupo();
			$oPersona = new TPersona();
			$result = $oGrupo->db->consultar_unico("SELECT 1 FROM {$oPersona->joinsTo['TPrograma']}
                                             WHERE cod_interno = $cod_interno AND $cod_curso = $cod_curso");
			return!empty($result);
		}

                /**
                 * ???
                 *
                 * @param int $cedula
                 * @param int $cod_grupo
                 * @return mixed
                 */
		function registrarEstudiante($cedula, $cod_grupo) {
			$oGrupo = new TGrupo();
			$cod_interno = TPersona::cod_interno($cedula);
			if (is_null($cod_interno))
				return FALSE;
		}

		/**
		 * Genera una consulta SQL de los cursos propios de un programa
		 * @param string $cod_programa codigo del programa a tratar.
		 * En caso de omitirse, se empleara el codigo del programa mas actual.
		 * @param string $tipo tipo de grupos a listar
		 * @return string
		 */
		function toSQL($cod_programa=null, $tipo=null) {
			if (is_blank($cod_programa))
				$cod_programa = TPrograma::max();
      $sql = "SELECT cod_grupo, nombre_grupo FROM v_grupo WHERE cod_programa = '$cod_programa'";
      if($tipo == NULL)
        $sql .= " AND tipo IS NULL";
      elseif($tipo != '*')
        $sql .= " AND tipo = '$tipo'";
      return $sql;
		}
    
    function all_to_sql($cod_programa = null){
      return TSubgrupo::toSQL($cod_programa, '*');
    }

                /**
                 * Inserta un componente a un curso dentro de un semestre especifico
                 *
                 * @param int $cod_curso
                 * @param int $cod_componente
                 * @param int $semestre
                 * @param int $cod_docente
                 */
		function adicionarComponente($cod_curso, $cod_componente=NULL, $semestre = NULL, $cod_docente=NULL) {
			$tablename = Config::get('TComponente', 'TGrupo');
			$data = array();
			if (is_array($cod_curso))
				$data = $cod_curso;
			else {
				$data = array('cod_curso' => $cod_curso, 'cod_componente' => $cod_componente, 'semestre' => 1);
				$data['codigo'] = DB::query("SELECT MAX(codigo)::integer + 1 FROM $tablename");
			}
			DB::query(sql_insert_from_array($tablename, $data));
		}

                /**
                 * Deculve el esquema-horario para un cruso especifico
                 *
                 * @param int $cod_curso
                 * @return array
                 */
		function esquemaHorario($cod_curso) {
			$sql = "SELECT * FROM ".Config::get('TCurso', 'Vista-Horario').
						 " WHERE cod_curso = '$cod_curso'";
			return DB::table_query($sql, 'cod_componente');
			return $horario;
		}

                /**
                 * Devuelve si existe o no un horario
                 *
                 * @param int $cod_horario
                 * @return boolean
                 */
		function existeHorario($cod_horario){
			$sql = "SELECT 1 FROM ".Config::get('TCurso','Horario')." WHERE codigo = '$cod_horario'";
			$r = DB::query($sql);
			return !empty($r);
		}
		
		/**
		 * Devuelve el horario de un curso
		 *
		 * @param int $cod_curso
		 * @return array
		 */
		function horario($cod_curso, $semestre=null) {
			$semestre = q($semestre);
			$sql = "SELECT clase.codigo AS cod_clase, cod_horario, dia, sede, edificio, salon, 
										hora_inicio, hora_fin, fecha_inicio, fecha_fin, 
										horario.observaciones AS observaciones_horario, anuncios,
										cod_componente, convert(nombre_componente,'LATIN1','UTF-8') AS nombre_componente,
										nombre_docente, fecha
							FROM " . Config::get('TCurso', 'Vista-Horario') . " horario".
						 " INNER JOIN ". Config::get('TClase'). " clase USING (cod_horario) ".
						 "WHERE cod_horario IS NOT NULL AND cod_curso = '$cod_curso'";
			if($semestre!= null)
				$sql .=" AND semestre = '$semestre'";
			$horario = DB::table_query($sql);
			return $horario;
		}

		/**
		 * Devuelve si un componente tiene o no relacion con un curso
		 *
		 * @param int $cod_curso
		 * @param int $cod_componente
		 * @return boolean
		 */
		function tieneRelacionConComponente($cod_curso, $cod_componente){
			$sql = "SELECT 1 FROM ".Config::get('TComponente','TGrupo')." WHERE cod_curso = '$cod_curso' AND cod_componente = '$cod_componente'";
			$result = DB::query($sql);
			return $result != null;
		}


		/**
		 * Devuelve informacion de las clases dentro de un componente y un curso especifico
		 *                  *
		 * @param int $cod_curso
		 * @param int $cod_componente
		 * @param array $options
		 * @return array
		 */
		function clases($cod_curso, $cod_componente, $options=array()){
			$sql = "SELECT c.codigo, cod_horario, fecha, c.observaciones, cod_docente
							FROM ".Config::get('TClase')." c INNER JOIN ".Config::get('TCurso','Horario')." h ON cod_horario = h.codigo
								INNER JOIN ".Config::get('TComponente','TGrupo')." cc ON cod_componente_curso = cc.codigo ".
						 " WHERE cod_curso = '$cod_curso' AND cod_componente = '$cod_componente'";
						 
			if(isset($options['maxDate']))
				$sql .= " AND fecha <='{$options['maxDate']}'";
			if(isset($options['minDate']))
				$sql .= " AND fecha >='{$options['minDate']}'";
			return DB::table_query($sql);
		}

                /**
                 * Devuelve la informacion de asistencias de las distintas clases de un curso especifico
                 *
                 * @param int $cod_curso
                 * @param int $cod_componente
                 * @return array
                 */
		function clasesConAsistencias($cod_curso, $cod_componente=null){
			$sql = "SELECT DISTINCT clase.codigo FROM ".Config::get('TClase')." clase " .
						 " INNER JOIN ".Config::get('TCurso','Horario')." horario ON horario.codigo=clase.cod_horario ".
						 " INNER JOIN ".Config::get('TComponente','TGrupo')." c ON c.codigo = horario.cod_componente_curso ".
						 " INNER JOIN ".Config::Get('TAsistencia')." ON cod_clase = clase.codigo ".
						 " WHERE cod_curso = '$cod_curso' ";
			if($cod_componente != null)
				$sql .=" AND cod_componente = '$cod_componente' ";

			return DB::aquery($sql);
		}
    
    function esEspecial($cod_curso){
      $sql = "SELECT tipo FROM v_grupo WHERE cod_grupo = '$cod_curso'";
      $rs = $this->db->fetchOne($sql);
      return $rs == 'TF';
    }

	}

?>
