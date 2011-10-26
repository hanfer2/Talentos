<?php 
  AppLoader::load_model('Extra/SubeEstudiantes/AbstractSubeParticipantes');
  
  if(!function_exists('calcular_edad')){
    function calcular_edad($fechaNacimiento) {
    	if(is_blank($fechaNacimiento))
    		return FALSE;
        
      list($year, $mes, $dia) = explode("-",$fechaNacimiento);
      
      $anio_dif = date("Y") - $year;
      $mes_dif = date("m") - $mes;
      $dia_dif = date("d") - $dia;
      if ($dia_dif < 0 || $mes_dif < 0)
        $anio_dif--;
      return $anio_dif;
    }
  }

  define('EDAD_MAXIMA', 23);
  
  
  class SubeParticipantes extends AbstractSubeParticipantes {
    
    function get_max_cod_interno(){
      $sql = "SELECT MAX(cod_interno) FROM ". $this->tablename;
      return $this->db->fetchOne($sql);
    }
    
    function procesar_datos(){
      $nbEstudiantes = count($this->csv);
      $cod_interno = $this->get_max_cod_interno();
      $cod_interno++;
      for($i=1; $i< $nbEstudiantes; $i++){
        $this->current_item = $i + 1;
        $datos = array_combine($this->header, $this->csv[$i]);

	print_r ($datos);

        if($this->valida_estudiante($datos)){
          $datos = $this->limpiar_datos($datos);
          $datos['cod_interno'] = $cod_interno;
          $subio = $this->_subir($datos);
          if($subio){
            $this->nbRegistros++;
            ++$cod_interno;
          }
        }
      }
    }
    

    
    function limpiar_datos($datos){
      $datos['cod_tipo_per'] = COD_TIPO_ESTUDIANTE;
      $datos['cod_estado'] = COD_ESTADO_ADMITIDO;
      $datos['fecha_ingreso'] = date('Y-m-d');
      $datos['email'] = lower($datos['email']);
      $datos['email_2'] = lower($datos['email_2']);
      return $datos;
    }
    
    
    function valida_estudiante($estudiante){

      if(is_blank($estudiante['estrato']) || $estudiante['estrato'] > 3){
          $this->Logger[] = sprintf('<b class="err">[Error]</b> Linea %s, Doc. Id: %s - Estrato NO Valido: <em>%s</em>', $this->current_item, $estudiante['cedula'], is_blank($estudiante['estrato'])? 'NULL': $estudiante['estrato']);
          return false;
      }
      if(is_blank($estudiante['fecha_nacimiento'])){
        $this->Logger[] = sprintf('<b class="err">[Error]</b> Linea %s, Doc. Id: %s - Fecha de Nacimiento NO Valida: <em>NULL</em>', $this->current_item, $estudiante['cedula']);
        return false;
      }
      $edad = calcular_edad($estudiante['fecha_nacimiento']);
      
      if($edad > EDAD_MAXIMA){
        $this->Logger[] = sprintf('<b class="err">[Error]</b> Linea %s, Doc. Id: %s - Edad NO Valida: <em>%s</em>, Fecha Ingresada: <em>%s</em>', $this->current_item, $estudiante['cedula'], $edad, $estudiante['fecha_nacimiento']);
        return false;
      }
      
      return true;
    }
    
  }
