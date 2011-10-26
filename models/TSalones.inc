<?php


  /**
   * Clase TSalones extendida de Tbase
   */
  class TSalones extends TBase {

    function __construct(){
    parent::__construct();
    $this->tablename = "a_salones";
   }
    
		function max($field=null){
			$sql = "SELECT max(codigo) FROM a_salones ";
      return DB::fetchOne($sql);
      
   }
     
    
     function crear($valores) {
     if(is_blank($valores['codigo'])) {
       $codigo = TSalones::max();
       $valores['codigo'] = $codigo + 1;
     }
     
     DB::query(sql_insert_from_array('a_salones', $valores));
    }
    
    function all(){
    $sql = "SELECT se.nombre as sede ,s.edificio,s.salon FROM a_salones s JOIN re_sedes se ON s.sede=se.codigo";
    return DB::table_query($sql);
      
    }
      
  	
  }
?>
