<?php
  /**
   * Clase TCarrera extendida de TBase
   */
  class TCarrera extends TBase {
    /**
     * @var string Guarda el nombre de la tabla con la informacion de carreras
     */
    var $tablename = 're_carreras';

    /**
     * Devuelve todos los campos de la tabla en el resultado de una consulta a la misma
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
     * Devuelve el nombre de una carrera segun el codigo entregado
     *
     * @param int $codigo
     * @return array
     */
    function nombre($codigo){
      return TCarrera::get($codigo,'nombre');
    }

    /**
     * maximum ???
     *
     * @param string $select
     * @param array $conditions
     * @return <type>
     */
    function max($select='codigo::int', $conditions=''){
      $max = parent::max(__CLASS__,$select, $conditions);
      return $max;
    }

    /**
     * Adiciona un carrera (codigo y nombre) dentro de la tabla
     *
     * @param array $data
     */
    function add($data){
      $data['codigo'] = TCarrera::max() + 1;
      $sql  = sql_insert_from_array(Config::get('TCarrera'), $data);
      DB::query($sql);
    }
    
    function modalidades(){
			 return array('PR'=>'PRESENCIAL','DT'=>'DISTANCIA TRADICIONAL','DV'=>'DISTANCIA VIRTUAL');
		}
		
		/**
     * Devuelve el listado de todas las carreras asociadas a una universidad y ciudad indicada y
     * cuyo nombre contiene a $pattern .
     * 
     * @param string $pattern Parte del nombre de la carrera a buscar
     * @param int $cod_ciudad codigo de la ciudad al que la universidad debe pertenecer
     * @param int $cod_universidad codigo de la universidad al que la carrera debe pertenecer
     * @param int $limit limite maximo de universidades a buscar. 
     * 	En caso de ser NULL, se asignara el valor de <<App.AC_DEFAULT_LIMIT>>
     */
		function find_by_pattern($pattern, $cod_ciudad, $cod_universidad, $limit=null){
			// Revisar parametros.
			if(is_blank($pattern))
				return FALSE;
			$pattern = q($pattern);
			if(is_blank($cod_ciudad))
				return FALSE;
			if(is_blank($cod_universidad))
				return FALSE;
			if($limit == null || !is_numeric($limit))
					$limit = Config::Get('App', 'AC_DEFAULT_LIMIT');
				
			$sql = "SELECT codigo, nombre FROM ".Config::get(__CLASS__) ." ".
							"WHERE clean_string(upper(nombre)) LIKE clean_string(upper('%$pattern%'))".
							"	AND cod_ciudad = '$cod_ciudad' AND cod_universidad='$cod_universidad' ORDER BY nombre LIMIT $limit";
			return DB::table_query($sql);
		}
}
?>
