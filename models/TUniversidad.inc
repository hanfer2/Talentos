<?php
  require_once 'TCiudad.inc';

  /**
   * Clase TUniversidad extendida de TBase
   */
  class TUniversidad extends TBase {

    /**
     * Devuelve el listado de todas las universidades 
     * cuyo nombre contiene a $pattern y pertenece a la ciudad indicada .
     * 
     * @param string $pattern Parte del nombre de la universidad a buscar
     * @param int $cod_ciudad codigo de la ciudad al que la universidad debe pertenecer
     * @param int $limit limite maximo de universidades a buscar. 
     * 	En caso de ser NULL, se asignara el valor de <<App.AC_DEFAULT_LIMIT>>
     */
    function find_by_pattern($pattern,$cod_ciudad,$limit=5){
			// Revisar parametros.
			if(is_blank($pattern))
				return FALSE;
			$pattern = q($pattern);
			if(is_blank($cod_ciudad))
				return FALSE;
			
			if($limit == null || !is_numeric($limit))
					$limit = Config::Get('App', 'AC_DEFAULT_LIMIT');
			$sql = "SELECT codigo, nombre FROM ".Config::get(__CLASS__) ." ".
							"WHERE clean_string(upper(nombre)) LIKE clean_string(upper('%$pattern%'))".
							"	AND cod_ciudad = '$cod_ciudad' ORDER BY nombre LIMIT $limit";
			return DB::table_query($sql);
		}

    /**
     * Devuelve el resultado de una consulta con algunos los campos
     *
     * @param int $codigo
     * @param string $select
     * @param array $options
     * @return array
     */
    function get($codigo, $select='*', $options=array()){
      return parent::get(__CLASS__, $codigo, $select, $options);
    }

    /**
     * Devuelve el resultado de una consulta con todos los campos
     *
     * @param array $options
     * @return array
     */
    function all($options=array()){
      return parent::all(__CLASS__,$options);
    }

    /**
     * Limita la consulta al primer resultado encontrado
     *
     * @param array $options
     * @return array
     */
    function first($options=array()){
      return parent::first(__CLASS__, $options);
    }
    
    /**
     * ???
     *
     * @param <type> $select
     * @return <type>
     */
    function maximum($select){
      return parent::maximum(Config::get(__class__));
    }

    /**
     * Deuelve el nombre de la Universidad segun el codigo
     *
     * @param int $codigo
     * @return string
     */
    function nombre($codigo){
      return TUniversidad::get($codigo,'nombre');
    }

    /**
     * Devuelve la listado de egresados que ingresaron a una universidad (y carrera, si es especificada)
     *
     * @param int $cod_universidad codigo de la universidad a la que deben pertenecer los egresados a listar
     * @param int $cod_carrera codigo de la carrera a la que deben pertenecer los egresados a listar
     * @return array 
     */
    function egresados($cod_universidad, $cod_carrera=null){
      $args = array('tablename'=>Config::get('TEgresado', 'TUniversidad'),
                    'cod_universidad'=>$cod_universidad);
      $sql = sprintfn(
            "SELECT * FROM %(tablename)s
             WHERE cod_universidad = '%(cod_universidad)s' ", $args);
      if(!is_blank($cod_carrera))
        $sql .= " AND cod_carrera = '$cod_carrera'";
      $db = DB::instance();
      return $db->fetch_array($sql);
    }

    /**
     * Inserta una universidad en el sistema.
     *
     * @param array $datos
     */
    function create($datos){
      $pk = Config::get("TUniversidad", "primary_key");
      $codigo = TUniversidad::maximum($pk);
      $datos[$pk] = $codigo + 1;
      DB::query(sql_insert_from_array(Config::get("TUniversidad", "tablename"), $datos));
    }
    
    /**
     * Retorna el listado de las carreras asociadas a una universidad indicada.
     * 
     * @param string $cod_universidad Codigo de la universidad con las carreras a buscar.
     * @param string $cod_ciudad Codigo de la ciudad de las carreras a buscar.
     * @param string $pattern parte del nombre que debe contener la carrera.
     * @return array [codigo, nombre] listado de las carreras asociadas a la universidad indicada.
     */
    function carreras($cod_universidad, $cod_ciudad, $pattern=null){
			$cod_universidad = q($cod_universidad);
			$cod_ciudad = q($cod_ciudad);
			$sql = "SELECT codigo, nombre FROM ".Config::Get('TCarrera').
						 " WHERE cod_universidad = '$cod_universidad' AND cod_ciudad = '$cod_ciudad'";
			if(!is_blank($pattern)){
				$pattern = q($pattern);
				$sql .= " AND clean_string(upper(nombre)) LIKE clean_string(upper('%$pattern%'))";
			}
			return $this->db->table_query($sql);
		}

  }
  
  require_once 'TCarrera.inc';
?>
