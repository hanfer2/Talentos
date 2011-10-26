<?php
  /**
   * Clase TCiudad extendida de TBase
   */
  class TCiudad extends TBase {

    /**
     * Devuelve el resultado de una consulta con las opciones especificadas
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
     * Devuelve el resultado de una consulta con las opciones especificadas
     *
     * @param array $options
     * @return array
     */
    function all($options=array()){
      return parent::all(__CLASS__,$options);
    }

    /**
     * Devuelve la primera fila del resultado de una consulta
     *
     * @param array $options
     * @return array
     */
    function first($options=array()){
      return parent::first(__CLASS__, $options);
    }
    
    /**
     * Consulta el nombre de una ciudad, indicandole el codigo
     *
     * @param int $codigo codigo de la ciudad
     * @return string nombre de la ciudad
     */
    function nombre($codigo) {
      return TCiudad::get($codigo, 'nombre');
    }

    /**
     * Devuelve una cadena con la consulta a la tabla
     *
     * @return string
     */
    function toSQL() {
      $args = Config::getModel(__CLASS__);
      return sprintfn("SELECT codigo, nombre FROM %(tablename)s ORDER BY %(order)s",$args);
    }
    
    function toArray(){
				return DB::table_query(TCiudad::toSQL());
		}
		
	 /**
    * Retorna el listado de las ciudades cuyo nombre cumplan con el patron $pattern.
    * 
    * @param string $pattern patron que debe cumplir las ciudades a listar.
    * @param int	$limit	numero maximo de ciudades a mostrar. Por defecto <<App.AC_DEFAULT_LIMIT>>
    * @return array listado de ciudades
		*/
		function find_by_pattern($pattern, $limit=null){
			// Revisar parametros.
			if(is_blank($pattern))
				return FALSE;
			$pattern = q($pattern);
			
			if($limit == null || !is_numeric($limit))
				$limit = Config::Get('App', 'AC_DEFAULT_LIMIT');
				
			$sql = "SELECT codigo, clean_string(nombre) AS nombre FROM ".Config::get(__CLASS__) ." ".
							"WHERE clean_string(upper(nombre)) LIKE clean_string(upper('%$pattern%')) ORDER BY nombre LIMIT $limit";
			return DB::table_query($sql);
		}
  }
	/**
         * Clase TBarrio extendida de TBase
         */
	class TBarrio extends TBase{
		/**
		 * Devuelve una cadena con la consulta a la tabla
		 *
		 * @return string
		 */
		function toSQL(){
			$args = Config::getModel(__CLASS__);
			return sprintfn("SELECT codigo, nombre FROM %(tablename)s ORDER BY codigo",$args);
		}

		/**
		 * Devuelve el resultado de una consulta con las opciones especificadas
		 *
		 * @param int $codigo
		 * @param string $field
		 * @param array $options
		 * @return array
		 */
		function get($codigo, $field, $options= array()){
			return parent::get(__CLASS__, $codigo, $field, $options);
		}

		/**
		 * Devuelve el nombre segun el codigo indicado
		 *
		 * @param int $codigo
		 * @return string nombre del barrio
		 */
		function nombre($codigo){
			return TBarrio::get($codigo, 'nombre');
		}
		
		/**
    * Retorna el listado de los barrios cuyo nombre cumplan con el patron $pattern.
    * 
    * @param string $pattern patron que debe cumplir los barrios a listar.
    * @param int	$limit	numero maximo de barrios a mostrar. Por defecto <<App.AC_DEFAULT_LIMIT>>
    * @return array listado de barrios
		*/
		function find_by_pattern($pattern, $limit=null){
			// Revisar parametros.
			if(is_blank($pattern))
				return FALSE;
			$pattern = q($pattern);
			
			if($limit == null || !is_numeric($limit))
				$limit = Config::Get('App', 'AC_DEFAULT_LIMIT');
				
			$sql = "SELECT codigo, clean_string(nombre) AS nombre FROM ".Config::get(__CLASS__) ." ".
							"WHERE clean_string(upper(nombre)) LIKE clean_string(upper('%$pattern%')) ORDER BY nombre LIMIT $limit";
			return DB::table_query($sql);
		}
	}

?>
