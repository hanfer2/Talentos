<?php
 /**
  * Se incluye el archivo TEstudiante.inc
  */
  require_once 'TEstudiante.inc';
  /**
   * Define la constante IES_TEXT como INGRESO A EDUCACION SUPERIOR
   */
  define('IES_TEXT', 'INGRESO A EDUCACION SUPERIOR');

  /**
   * Clase TEgresado extendida de TEstudiante
   *
   * Esta clase agrupa las funciones propias de un estudiante egresado del Plan Talentos.
   */
  class TEgresado extends TEstudiante {
		function __construct(){
			parent::__construct();
			$this->tablename = $this->Config->get(__CLASS__);
		}
		

    /**
     * Indica si un estudiante ya esta registrado como que ingreso a Educacion Superior.
     *
     * @param string $cedula cedula del estudiante a consultar
     * @return bool TRUE si ya esta registrado, false
     */
    function ingresoEducacionSuperior($cedula) {
      $estudiante = TEgresado::universidad($cedula, array('select' => '1'));
      return!empty($estudiante);
    }

    /**
     * Devuelve la informacion de la situacion actual de un egresado segun las opciones especificadas
     *
     * @param int $cedula numero de cedula (documento de identidad) del egresado
     * @param array $options opciones de la consulta
     * @return array informacion de la situacion actual del egresado
     */
    function situacion($cedula, $options=array()) {
      $config = &Config::getInstance();
      $args = array(
          'select' => any($options['select'], '*'),
          'estudiantes_universidades' => $config->getAttribute('TEstudiante', 'TUniversidad'),
          'estudiantes_pk' => $config->getAttribute('TEstudiante', 'primary_key'),
          'egresados_trabajando' => $config->getAttribute('TEgresado', 'Trabajo'),
          'egresados_universidades' => $config->getAttribute('TEgresado', 'TUniversidad'),
          'programas_tablename' => $config->getAttribute('TEstudiante', 'TPrograma'),
          'cod_interno' => TEstudiante::cod_interno($cedula)
      );
      $sql = sprintfn(
        "SELECT %(select)s, pe_estudiantes_universidades.fecha_ingreso as fecha_ingreso_univ
               FROM %(estudiantes_universidades)s
                  INNER JOIN %(egresados_universidades)s USING (%(estudiantes_pk)s)
                  FULL OUTER JOIN %(egresados_trabajando)s USING (%(estudiantes_pk)s)
                  INNER JOIN %(programas_tablename)s USING (%(estudiantes_pk)s)
               WHERE cod_interno = %(cod_interno)s", $args);
      return DB::query($sql);
    }

    /**
     * Retorna la Informacion de la Universidad a la que un estudiante esta vinculado.
     *
     * @param string $cedula cedula del estudiante a consultar
     * @param array $options condiciones de consulta.
     * @return array Datos de la Universidad a la que esta el estudiante vinculado.
     */
    function universidad($cedula, $options=array()) {
      $config = &Config::getInstance();
      $args = array(
          'select' => any($options['select'], '*'),
          'estudiantes_universidades' => $config->getAttribute('TEstudiante', 'TUniversidad'),
          'estudiantes_pk' => $config->getAttribute('TEstudiante', 'primary_key'),
          'cod_interno' => TEstudiante::cod_interno($cedula)
      );
      $sql = sprintfn(
        "SELECT %(select)s
               FROM %(estudiantes_universidades)s
                  INNER JOIN v_egresados_universidades USING (%(estudiantes_pk)s)
               WHERE cod_interno = %(cod_interno)s", $args);
      return DB::query($sql);
    }

    /**
     * Elimina el registro de un estudiante de la tabla de Estudiantes que Ingresaron a Eduacion Superior.
     *
     * @param string $cedula cedula del estudiante a eliminar.
     */
    function eliminarIES($cedula) {
      $config = &Config::getInstance();
      $args = array(
          'estudiantes_universidades' => $config->getAttribute('TEstudiante', 'TUniversidad'),
          'cod_interno' => TEstudiante::cod_interno($cedula)
      );
      $sql = sprintfn("DELETE FROM %(estudiantes_universidades)s
                       WHERE cod_interno = '%(cod_interno)s'", $args);
      DB::query($sql);
    }

    /**
     * Elimina el registro que indica que el estudiante se encuentra laborando
     *
     * @param string $cedula cedula del estudiante a consultar.
     */
    function eliminarTrabajando($cedula) {
      $config = &Config::getInstance();
      $args = array(
          'egresados_trabajando' => $config->getAttribute('TEgresado', 'Trabajo'),
          'cod_interno' => TEstudiante::cod_interno($cedula)
      );

      $sql = sprintfn("DELETE FROM %(egresados_trabajando)s
                       WHERE cod_interno = '%(cod_interno)s'", $args);
      DB::query($sql);
    }

    /**
     * Registra a un estudiante en la tabla de Estudiantes que Ingresaron a Educacion Superior.
     *
     * @param string $cedula cedula del estudiante a registrar
     * @param array $data datos del registro.
     */
    function ingresarEducacionSuperior($cedula, $data) {
      $data['cod_interno'] = TEstudiante::cod_interno($cedula);
      $sql = sql_insert_from_array(Config::get('TEstudiante', 'TUniversidad'), $data);
      DB::query($sql);
    }

    /**
     * Indica si un estudiante esta registrado como laborando
     *
     * @param string $cedula cedula del estudiante a consultar
     * @return bool True si esta trabajando, de lo contrario FALSE
     */
    function estaTrabajando($cedula) {
      $db = &DB::instance();
      $cod_interno = TEstudiante::cod_interno($cedula);
      $egresados_trabajando = Config::get('TEgresado', 'Trabajo');
      $estaTrabajando = $db->fetch("SELECT 1 FROM $egresados_trabajando WHERE cod_interno = $cod_interno");
      return!empty($estaTrabajando);
    }

    /**
     * Registra a un estudiante como trabajador.
     *
     * @param string $cedula cedula del estudiante a registrar.
     * @param array $datos datos a almacenar.
     */
    function registrarComoTrabajador($cedula, $datos) {
      $datos['cod_interno'] = TEstudiante::cod_interno($cedula);
      DB::query(sql_insert_from_array(Config::get("TEgresado", "Trabajo"), $datos));
    }

    /**
     * Consulta los datos laborales de un estudiante egresado.
     *
     * @param string $cedula cedula del estudiante a consultar.
     * @return array datos laborales del estudiante.
     */
    function trabajo($cedula) {
      $args = array('egresados_trabajando' => Config::get('TEgresado', 'Trabajo'),
          'estudiantes_programa' => Config::get('TEstudiante', 'view-TPrograma'));
      $sql = sprintfn(
        "SELECT * FROM %(egresados_trabajando)s
                      INNER JOIN %(estudiantes_programa)s USING (cod_interno)
              WHERE cedula = $cedula", $args);
              
      return DB::table_query($sql);
    }

    /**
     * ???
     *
     * @param int $cod_programa programa al que pertence el egresado
     * @return array
     */
    function informe($cod_programa){
      AppLoader::load_model('Reports/Egresado');
      //require_once CARPETA_MODELOS_INFORMES ."Egresado.inc";
      $oInforme = new InformeEgresado($cod_programa);
      return $oInforme->process();
    }
    
    /**
     * Devuelve un arreglo con los estudiantes de un programa especifico que se encuentran laborando
     * actualmente
     *
     * @param int $cod_programa
     * @return array
     */
    function laborando($cod_programa) {
      $args = array(
				'trabajadores_tablename' => Config::get('TEgresado', 'Trabajo'),
        'estudiantes_programas' => Config::get('TEstudiante', 'TPrograma'));
      $sql = sprintfn(
        "SELECT cod_interno, cedula, fullname, ocupacion
           FROM %(trabajadores_tablename)s INNER JOIN %(estudiantes_programas)s
            USING (cod_interno)
           WHERE cod_programa = '$cod_programa'", $args);
      return DB::table_query($sql);
    }

  }

?>
