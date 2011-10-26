<?php

  /**
   * Se incluye el archivo TBaseModel.inc
   */
  require_once 'TBaseModel.inc';

  /**
   * clase TColegio extendida de TBase
   */
  class TColegio extends TBase {

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
     * maximum ???
     *
     * @param <type> $select
     * @return <type>
     */
    function maximum($select){
      return parent::maximum(Config::get(__class__));
    }

    /**
     * Devuelve el nombre del colegio segun el codigo entregado
     *
     * @param int $codigo
     * @return array
     */
    function nombre($codigo){
      return TColegio::get($codigo,'nombre');
    }

          /**
           * Devuelve un arreglo con la informacion de los estudiantes y su respectivo colegio
           *
           * @param int $cod_programa
           * @return array
           */
	  function informe($cod_programa){
	  	$sql = "SELECT cod_colegio, colegios.nombre AS nombre, COUNT(*) AS cantidad 
	  					FROM ".Config::get(__CLASS__, 'TEstudiante').
  					" INNER JOIN ".Config::get(__CLASS__)." colegios ON cod_colegio = colegios.codigo".
  					" INNER JOIN ".Config::get('TEstudiante','TPrograma') . " USING (cod_interno)".
  					" WHERE cod_programa ='$cod_programa'".
  					" GROUP BY cod_colegio, nombre
  						ORDER BY cod_colegio DESC";
  		return DB::table_query($sql);
	  }    

    /**
     *
     *
     * @param string $filename
     * @param <type> $keys
     */
    function __cargarColegiosEstudiantes($filename, $keys){
    	$estudiantes = CSV::load($filename,";");
    	$colegios = array();
    	$COLEGIO_IDX = 1;
    	$cod_internos = DB::table_query("SELECT cod_interno, cod_estud FROM a_persona where a_persona.cod_estado = 11 AND cod_tipo_per = '1'","cod_estud");
    	foreach($estudiantes as $estudiante){
    		$colegios[$estudiante[$COLEGIO_IDX]] = 0; 
    	}
    	
    	$sql = "SELECT codigo FROM ".Config::get(__CLASS__)." WHERE codigo IN (".sql_rangeize(array_keys($colegios)).")";
    	$colegios = DB::table_query($sql, "codigo");
    	$counter = 0;
    	$estudiantesNoRegistrados = array();
    	$estudiantesConColegios = array();
			$colegiosNoRegistrados = array();
			$db = DB::instance();
			foreach($estudiantes as $estudiante){
				$estudiante = array_combine($keys, $estudiante);
    		$data = array();
    		$cod_interno = $cod_internos[trim($estudiante['cod_estud'])][0]['cod_interno'];
    		if(is_null($cod_interno)){
    			$estudiantesNoRegistrados[$estudiante[0]] = 0;
    			continue;
    		}
    		
    		if(!array_key_exists($estudiante[1], $colegios) && !is_blank($estudiante[1])){
    			$colegiosNoRegistrados[$estudiante[1]] = $estudiante[2];
					continue;
    		}
    		
    		if(is_blank($estudiante[1])){
    			$estudiante[1] = 0;
    		}
    		
    		$data['cod_interno'] = $cod_interno;	
    		$data['cod_colegio'] = $estudiante['cod_colegio'];
    		$data['fecha_bachiller'] = $estudiante['fecha_finalizacion'];
    		
    		$sql = sql_insert_from_array(Config::get(__CLASS__, 'TEstudiante'), $data);
    		$db->consulta($sql);
    		echo $sql.";<br/>";
    		
//    		$counter++;
    	}
    	echo "<h1>ESTUDIANTES NO REGISTRADOS</h1>";
    	debug($estudiantesNoRegistrados);
    	echo "<h1>COLEGIOS NO REGISTRADOS</h1>";    	
			debug($colegiosNoRegistrados);
    	
    }
  }
  
  /*FUNCIONES EXTRAS**/
  /**
   * Funcion auxiliar que permite la asignacion del tipo a cada colegio (PRIVADO/OFICIAL) en masa
   * 
   * @param string $filename $nombre del archivo CSV con la informacion
   * @param array $keys un arreglo con la cabecera del CSV. Los valores requeridos son: tipo, cod_colegio.
   */
  function Colegio_definirTipoColegioEnMasa($filename, $keys){
			$colegios = CSV::load($filename,';');
			$colegiosNoRegistrados = array();
			$db = DB::instance();
			foreach($colegios as $colegio){
				$colegio = array_combine($keys, $colegio);
				$sql = sql_update_from_array(Config::get('TColegio'),array('tipo'=>$colegio['tipo']), "codigo = '{$colegio['cod_colegio']}'");
				$db->consulta($sql);
				echo $sql."<br/>";
			}
		}

?>
