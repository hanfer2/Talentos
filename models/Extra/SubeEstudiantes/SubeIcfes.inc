<?php 
  AppLoader::load_model('Extra/SubeEstudiantes/AbstractSubeParticipantes');
  
  class SubeIcfes extends AbstractSubeParticipantes{
    
   function setup(){
     $this->tablename = 'a_estudiantes_icfes';
   }
   
   function procesar_datos(){
     $nbEstudiantes = count($this->csv);
     
     for($i=1; $i<$nbEstudiantes; $i++){
       $this->current_item = $i + 1;
       $datos = array_combine($this->header, $this->csv[$i]);
       if($this->valida_icfes($datos)){
        $cedula = $datos['cedula'];
        $datos = $this->limpiar_datos($datos);
        $sql = $this->generate_sql($datos, $cedula);
        $this->db->consulta($sql);
        if($this->db->hasError())
          $this->Logger[] = sprintf('<b class="err sql">[SQL Error]</b> Linea %s, Doc. Id: %s - %s', $this->current_item, $datos['cedula'], $this->db->error);
       }else{
         $this->nbRegistros++;
       }
     }
   }
   
   function generate_sql($datos, $cedula){
     $keys = array_keys($datos);
     $values = array_map('db_format', $datos);
     $sql = sprintf("INSERT INTO %s (%s, \"cod_interno\") SELECT %s, cod_interno FROM a_persona WHERE cedula = '$cedula'", $this->tablename, join(', ', $keys), join(', ', $values));
     return $sql;
   }

   function valida_icfes($datos){
     return true;
   }
   
   function limpiar_datos($datos){
     unset($datos['cedula']);
     return $datos;
   }
    
  }
