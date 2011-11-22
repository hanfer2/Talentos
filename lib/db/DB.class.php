<?php

/**
 * Incluye el archivo de configuracion
 */

define("DB_NO_ERROR", 4);
/**
 * Conexion a la BD
 *
 * Clase con los metodos necesarios para conectarse a la BD, hacer consultas, y recuperar la informacion devuelta
 *
 */
class DB {
  /* variables de conexion */

  /**
   *
   * @var string Servidor de la BD
   */
  var $servidor;
  /**
   *
   * @var string Puerto de conexion a la BD
   */
  var $puerto;
  /**
   *
   * @var string Nombre de la BD
   */
  var $bd;
  /**
   *
   * @var string Usuario
   */
  var $usuario;
  /**
   *
   * @var string Password
   */
  var $password;

  /* Identificador de conexiones */
  /**
   *
   * @var int Id de la conexion a la BD
   */
  var $conexion_id = 0;
  /**
   *
   * @var array Resultado de la consulta
   */
  var $result_query;

  /* Identificador de errores */
  var $errno = 0;
  var $error = "";
  
  var $debug = true;

  /**
   * Singleton
   *
   * @staticvar DB $db
   * @param array $options arreglo de configuraciones.
   * @return DB
   */
  function &instance($options=array()){
    static $db = null;
    $const = &AppConst::getInstance();
    
    $options['user'] = isset($options['user']) ? $options['user'] : $const->get('siat_db_user');
    $options['passwd'] = isset($options['passwd']) ? $options['user'] : $const->get('siat_db_passwd');
    $options['host'] = isset($options['host']) ? $options['user'] : $const->get('siat_db_host');
    $options['port'] = isset($options['port']) ? $options['user'] : $const->get('siat_db_port');
    $options['dbname'] = isset($options['dbname']) ? $options['user'] : $const->get('siat_db_dbname');

    if ($db === null) {
      $db = new DB(
              $options['user'],
              $options['passwd'],
              $options['host'],
              $options['port'],
              $options['dbname']);
      $db->conectar();
    }
    return $db;
  }

  /**
   * Metodo constructor, cuando se llame una de estas variables siempre se ejecuta esta funcion
   *
   * @param string $user
   * @param string $pass
   * @param string $host
   * @param string $port
   * @param string $dbname
   */
  function DB($user="dintev", $pass="dintev", $host="localhost", $port="5432", $dbname="talentos_test") {
//  Para la OITEL:
//	function DB_pgsql($user="talentos_siat", $pass="128e3ffyi", $host="mobdse33.univalle.edu.co", $port="5432", $dbname="talentos_siat")
    //function DB_pgsql($user="postgres", $pass="", $host="localhost", $port="5432", $dbname="prueba")
    $this->usuario = $user;
    $this->password = $pass;
    $this->servidor = $host;
    $this->puerto = $port;
    $this->bd = $dbname;
  }

  /**
   * Conexion a la BD
   *
   * @return 0|int 0 si falla la conexion, de lo contrario devuelve el id de conexion
   */
  function conectar(){

    /* conectamos al servidor */

    $this->conexion_id = pg_connect("host=$this->servidor port=$this->puerto dbname=$this->bd user=$this->usuario password=$this->password");

    if (!$this->conexion_id) {
      $this->error = "La conexion a la Base de datos ha fallado.";
      $this->errno = 5;
      return FALSE;
    }


    /* si la conexion fue exitosa devuelve el id de conexion, sino devuelve 0 */
    return $this->conexion_id;
  }

  /**
   * Devuelve el resultado de una consulta
   *
   * @param string $sql Consulta
   * @return array Resultado de la consulta
   */
  function consulta($sql) {

    if (!$sql) {
      $this->error = "No ha ingresado una consulta valida.";
      $this->errno = 0;
      return 0;
    }

    if($this->debug)
      $this->result_query = pg_query($this->conexion_id, $sql);
    else
      $this->result_query = @pg_query($this->conexion_id, $sql);
    
    $logger = &Logger::getDefault();
    $logger->register_query($sql);
    
    if (pg_last_error($this->conexion_id)) {
      $this->error = pg_last_error($this->conexion_id);
      if($this->debug)
        echo "<span style='z-index:70'>SQL ERROR: {$this->error} <br/>SQL:$sql</span>";   //Linea para ConsultarProgramacionTotal.php
    } else {
      $this->error = "";
      $this->errno = DB_NO_ERROR;
    }

    return $this->result_query;
  }
  
  function hasError(){
		return $this->errno != DB_NO_ERROR;
	}

  /**
   * Devuelve un arreglo con el resultado de la consulta
   *
   * @param string $sql
   * @return array
   */
  function query($sql) {
    $db = &DB::instance();
    return $db->fetch($sql);
  }

  /**
   * Devuelve un arreglo con el resultado de la consulta, el arreglo es con indices numericos y asociativos
   *
   * @param string $sql
   * @return array
   */
  function aquery($sql) {
    $db = &DB::instance();
    $table = $db->fetch($sql);
    if ($table == null)
      return null;
    return arrayize($table);
  }

  /**
   * Devuelve un arreglo con la informacion de una consulta
   *
   * @param string $sql
   * @return null|array
   */
  function table_query($sql, $group_by=null) {
    $db = &DB::instance();
    $db->consulta($sql);
    $numFilas = $db->numfilas();
    if ($numFilas == 0)
      return null;
    $results = array();
    if (is_string($group_by) && !is_blank($group_by))
      $group_by = explode(',', $group_by);
    while ($result = pg_fetch_assoc($db->result_query)) {
      if (empty($group_by))
        $results[] = $result;
      else {
        if (!isset($results[$result[$group_by[0]]]))
          $results[$result[$group_by[0]]] = array();
        $results[$result[$group_by[0]]][] = $result;
      }
    }
    return $results;
  }

  function grouped_query($sql, $group_by) {
    $db = &DB::instance();
    $db->consulta($sql);
    $numFilas = $db->numfilas();
    if ($numFilas == 0)
      return null;
    $results = array();
    if (is_string($group_by) && !is_blank($group_by))
      $group_by = explode(',', $group_by);
    while ($result = pg_fetch_assoc($db->result_query)) {
      $results[$result[$group_by[0]]] = $result;
    }
    return $results;
  }

  /**
   * Devuelve el numero de campos de una consulta
   *
   * @return int
   */
  function numcampos() {
    return pg_num_fields($this->result_query);
  }

  /** Devuelve el numero de filas en un consulta
   *
   * @return int
   */
  function numfilas() {
    return pg_num_rows($this->result_query);
  }
  
  function fetch_object(){
    return pg_fetch_object($this->result_query);
  }

  /**
   * Devuelve un campo especifico
   *
   * @param int $numfila
   * @param int $numcampo
   * @return string
   */
  function valcampo($numfila, $numcampo) {
    if (is_string($numcampo))
      return $this->valcampo($numfila, pg_field_num($this->result_query, $numcampo));
    return trim(@pg_fetch_result($this->result_query, $numfila, $numcampo));
  }

  /**
   * Devuelve un campo especifico
   *
   * @param int $numfila
   * @param int $numcampo
   * @return string
   */
  function valcampo2($numfila, $numcampo) {
    $numcampo = pg_field_num($this->result_query, $numcampo);
    return trim(@pg_fetch_result($this->result_query, $numfila, $numcampo));
  }

  /**
   * Devuelve el nombre del campo
   *
   * @param int $col
   * @return string
   */
  function nombre_campo($col) {
    return pg_field_name($this->result_query, $col);
  }

  /**
   * Devuelve el numero de filas afectadas
   *
   * @return int
   */
  function numafectadas() {
    return pg_affected_rows($this->result_query);
  }

  /**
   * Retorna un arreglo NO Asociativo con los resultados de la consulta.
   * Es similar a fetch_array, con la diferencia que el arreglo NO es asociativo.
   *
   * @param string $query Consulta
   * @return null|array
   */
  function fetch_rows($query) {
    $this->consulta($query);
    $numFilas = $this->numfilas();
    if ($numFilas == 0)
      return null;
    $results = array();
    while ($result = pg_fetch_row($this->result_query))
      $results[] = $result;
    return $results;
  }

  /**
   * Realiza una consulta y retorna el resultado en forma de arreglo asociativo.
   * En caso de no requerirlo como arreglo asociativo, emplear @link fetch_row
   *
   * @param string $query consulta
   * @param bool $alwaysArray indica si siempre se retorna el resultado como arreglo, aun teniendo un solo resultado.
   * @return array arreglo con los datos que arrojo la consulta.
   */
  function fetch_array($query) {
    $this->consulta($query);
    $numFilas = $this->numfilas();
    $numCols = $this->numcampos();
    switch ($numFilas) {
      case 0:
        return null;
      case 1:
        return pg_fetch_assoc($this->result_query, 0);
      default:
        $results = array();
        if ($numCols == 1) {
          while ($result = pg_fetch_assoc($this->result_query))
            $results = array_merge($results, $result);
          return $results;
        }else
          while ($result = pg_fetch_assoc($this->result_query)) {
            $results[] = $result;
          }
        return $results;
    }
  }

  /**
   * Retorna el resultado de una consulta.
   *
   * @param string $query consulta
   * @return mixed Resultado de la consulta
   *  Si la consulta no arroja resultado, retorna null
   *  Si la consulta arroja un solo valor, lo retorna como string
   *  Si la consulta arroja un registro con varias columnas, lo retorna como arreglo asociativo
   *  Si la consulta arroja varios registros con una columna, los retorna como arreglo asociativo
   *  Si la consulta arroja varios registros con varias columnas, los retorna como multiarreglo asociativo.
   */
  function fetch($query) {
    if (is_blank($query))
      return null;
    $this->consulta($query);
    $numFilas = $this->numfilas();
    $numCols = $this->numcampos();
    if ($numFilas == 0)
      return null;

    $results = array();
    if ($numCols == 1) {
      if ($numFilas == 1)
        return $this->valcampo(0, 0);
      for ($i = 0; $i < $numFilas; $i++)
        $results[] = $this->valcampo($i, 0);
      return $results;
    }
    if ($numFilas == 1) {
      while ($result = pg_fetch_assoc($this->result_query))
        $results = array_merge($results, $result);
      return $results;
    }

    while ($result = pg_fetch_assoc($this->result_query))
      $results[] = $result;

    return $results;
  }

  function assoc_query($query){
    $db = DB::instance();
    $db->consulta($query);
    $numFilas = $db->numfilas();
    if( $numFilas < 1)
        return null;
    $results = array();

    for($i=0; $i<$numFilas; $i++)
      $results[$db->valcampo($i,0)] = $db->valcampo($i,1);
    return $results;
  }
  
  function boolQuery($query){
		$db = DB::instance();
    $db->consulta($query);
    $rs = $db->valcampo(0,0);
    if($rs == null)
			return FALSE;
		return $rs == FALSE? FALSE: TRUE;
	}
	
	function fetchOne($query){
		$db = DB::instance();
    $db->consulta($query);
    return $db->valcampo(0,0);
	}

}

//////Fin de la clase DB_pgsql
/**
 *
 * @param array $options
 * @return <type>
 */
function &DB_new($options = array()) {
  return DB::instance($options);
}

/**
 * Devuelve una matriz con la informacion de una consulta
 *
 * @param string $tabla Nombre de la tabla
 * @return array Matriz resultado
 */
function DB_info_schema($tabla) {
  $db_connection = pg_connect("host=localhost port=5432 dbname=talentos user=dintev password=dintev");

  $query = "SELECT * FROM information_schema.columns WHERE table_name = '$tabla'";
  $result = pg_query($db_connection, $query);

  $total_filas = pg_num_rows($result);
  if ($total_filas == 0)
    return null;
  $total_cols = pg_num_fields($result);
  $array = array();

  for ($i = 0; $i < $total_filas; $i++) {
    for ($j = 0; $j < $total_cols; $j++)
      $array[$i][pg_field_name($result, $j)] = pg_fetch_result($result, $i, $j);
  }
  return $array;
}

/**
 * Devuelve un arreglo con indices numericos
 *
 * @param string $query Consulta
 * @return array
 */
function arrayize_query($query) {
  if (is_blank($query))
    return null;
  $db = DB_new();
  return $db->fetch_rows($query);
}

/**
 *
 * @param array $array
 * @return array
 */
function to_html_array($array) {
  $html_array = array();
  foreach ($array as $k => $v) {
    $keys = array_keys($v);
    if (count($keys) == 0)
      continue;
    if (count($keys) == 1)
      $html_array[$v[$keys[0]]] = $v[$keys[0]];
    else
      $html_array[$v[$keys[0]]] = $v[$keys[1]];
  }
  return $html_array;
}

?>
