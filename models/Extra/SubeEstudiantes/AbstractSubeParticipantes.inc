<?php 
  
  class AbstractSubeParticipantes {
    
    var $tablename = 'a_persona';
    var $db = null;

    function AbstractSubeParticipantes($csv){
      $this->Logger = array();
      $this->csv = $csv;
      $this->nbRegistros = 0;
      $this->db = DB::instance();
      $this->db->debug = false;
      $this->extraer_cabecera();
      $this->setup();
    }
    
    function extraer_cabecera(){
      $this->header = $this->csv[0];
    }
    
    function setup(){}
    
    function subir(){
      $this->procesar_datos();
      $this->imprimir_errores();
      $this->imprimir_exitos();
    }
    
    function _subir($datos){
      $sql = sql_insert_from_array($this->tablename,$datos);
      $this->db->consulta($sql);
      if($this->db->hasError()){
        $this->Logger[] = sprintf('<b class="err sql">[SQL Error]</b> Linea %s, Doc. Id: %s - %s', $this->current_item, $datos['cedula'], $this->db->error);
        return false;
      }
      return true;
    }
    
    function imprimir_exitos(){
      echo "<br/>Se lograron subir <b>{$this->nbRegistros}</b> registros<br/>";
    }
    function imprimir_errores(){
      $nbErrors = count($this->Logger);
      if($nbErrors > 0){
        echo "Se hallaron <b>$nbErrors</b> errores:<br/>";
        foreach($this->Logger as $log){
          echo "$log<br>";
        }
      }else{
        echo "El proceso de validacion NO arrojó errores";
      }
    }
    
  }
