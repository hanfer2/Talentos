<?php

 /**
  * Se incluye el archivo TBaseModel.inc
  */
 require_once 'TBaseModel.inc';

define('TCOMPONENTE_MODALIDAD_TF', 'TALLER FORMATIVO');
define('TCOMPONENTE_MODALIDAD_VU', 'VIDA UNIVERSITARIA');


 /**
  * Clase TComponente extendida de TBase
  */
 class TComponente extends TBase {
   
   function __construct()
   {
     parent::__construct();
     $this->tablename = $this->Config->get(__CLASS__);
   }
   
   function getTable($attr = 'tablename')
   {
     return Config::get(__CLASS__, $attr);
   }

   /**
    * Devuelve si existe o no un curso (componente)
    *
    * @param int $codigo
    * @return boolean
    */
   function exists($codigo) {
     $curso = TComponente::all($conditions = array('conditions'=>array('codigo'=>$codigo)));
     return !empty($curso);
   }

   /**
    * Devuelve un arreglo con las modalidades
    *
    * @return array
    */
   function modalidades() {
     return array(
       'ACADEMICO'=>'Académico',
       TCOMPONENTE_MODALIDAD_VU=>ucwords(lower(TCOMPONENTE_MODALIDAD_VU)),
       TCOMPONENTE_MODALIDAD_TF => ucwords(lower(TCOMPONENTE_MODALIDAD_TF)));
   }

        /**
         * Devuelve el nombre del componente segun el codigo entregado
         *
         * @param int $codigo
         * @return array
         */
	 function nombre($codigo){
		return parent::get(__CLASS__, $codigo, __FUNCTION__);
	 }

   /**
     * Devuelve el resultado de una consulta con las opciones especificadas
     *
     * @param array $options
     * @return array
     */
   function all($options=array()){
		 if(array_key_exists('cod_programa', (array)$options))
			$options['conditions'][] = " codigo IN (SELECT cod_componente FROM ".Config::get(__CLASS__,'TPrograma')." WHERE cod_programa = '{$options['cod_programa']}')" ;
     return parent::all(__CLASS__, $options);
   }

   /**
    * Inserta un componente
    *
    * @param array $valores
    */
   function crear($valores) {
     if(is_blank($valores['codigo'])) {
       $codigo = TComponente::max();
       $valores['codigo'] = $codigo + 1;
     }
     $valores['nombre'] = upper($valores['nombre']);
     DB::query(sql_insert_from_array(Config::get(__CLASS__), $valores));
   }

   /**
    * Crea un SQL para buscar modelos en la Base de Datos.
    * @param array $options opciones para la consulta SQL:
    *  select => campos a mostrar, por defecto: '*';
    *  conditions => condiciones del WHERE
    *  order => regla de ordenamiento
    *  group => regla de agrupamiento
    *  limit => numero limite de elementos a mostrar.
    * @return string
    */
   function toSQL($options=array()){
		if(empty($options))
			$options = array();
    if(empty($options['select']))
      $options['select'] = 'codigo, nombre';
		if(is_blank($options['cod_programa']))
			$options['cod_programa'] = TPrograma::max();
		$options['join'] = Config::get(__CLASS__, 'TPrograma') . " on cod_componente = ". Config::get(__CLASS__).".codigo";
		$options['conditions'] = array('cod_programa'=>$options['cod_programa']);
    return parent::toSQL(__CLASS__, $options);
   }

   /**
    * Devuelve el resultado de una consulta en un arreglo
    *
    * @param array $options
    * @return array
    */
   function toArray($options=array()){
   	return DB::table_query(TComponente::toSQL($options));
   }

   /**
    *
    * @param <type> $options
    * @return <type>
    */
   function toJSON($options=array()){
   	return JSON::encode(TComponente::toArray($options));
   }
   
   /**
    * Retorna los componentes que se encuentran disponibles 
    * para un determinado PNAT en un semestre indicado.
    * Es decir, aquellos componentes que NO se han asignado a ningun curso del PNAT.
    */
   function disponibles($cod_programa, $semestre=null){
     
		 $cod_programa = q($cod_programa);
		 $semestre = upper($semestre);
     
		 $sql = "SELECT codigo, nombre FROM ".$this->tablename." ". 
						"WHERE codigo NOT IN 
							(SELECT cod_componente FROM ".Config::Get(__CLASS__, 'TPrograma').
							" WHERE cod_programa = '$cod_programa' ";
			if($semestre != null && $semestre != 'CURSOS_ESPECIALES'){
          $sql .= sprintf(" AND semestre = '%s'", q($semestre));
			}
			$sql .=")";
      
      if($semestre == 'CURSOS_ESPECIALES'){
        $sql .= sprintf(" AND modalidad = '%s' ", TCOMPONENTE_MODALIDAD_TF);
      }
		
			return DB::table_query($sql);
	 }
	 
	 function sin_horario($cod_programa, $semestre){
		 $cod_programa = q($cod_programa);
		 
		 $sql = "SELECT codigo FROM ".$this->tablename.
						" WHERE codigo NOT IN (SELECT cod_componente FROM ".$this->getTable('TGrupo'). 
							"	WHERE codigo IN (SELECT cod_componente_curso FROM ".Config::Get('TCurso','Horario').") ".
								"	AND cod_curso IN (SELECT codigo FROM ".Config::Get('TGrupo')." WHERE cod_programa = '$cod_programa')";
							
			if($semestre != null){
        $semestre = upper($semestre);
				if($semestre == 'CURSOS_ESPECIALES'){
          $sql .= sprintf(" AND modalidad = '%s' ", TCOMPONENTE_MODALIDAD_TF);
        }else{
          $sql .= sprintf(" AND semestre = '$semestre'", q($semestre));
        }
			}
			$sql .=")";
		
			return DB::aquery($sql);
		}
    
    function talleres(){
      $sql = "SELECT * FROM a_componentes WHERE modalidad = '".TCOMPONENTE_MODALIDAD_TF."'";
      return $this->db->table_query($sql);
    }
    
    function getObject($codigo){
      $sql = "SELECT * FROM a_componentes WHERE codigo = $codigo";
      $db = &DB::instance();
      $db->consulta($sql);
      return $db->fetchObject();
    }
	
 }
?>
