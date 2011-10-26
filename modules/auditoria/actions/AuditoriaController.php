<?php

  class AuditoriaController extends Controller{
    
    function setup(){
      $this->includeModel('Auditoria','TEstudiante');

      $this->TPersona = new TPersona();
    }
    
      
    function view($params, $request){
      
    $nombre_cambio = "";
    $cambios = null;
    $persona = null;
    $cedula = null;
    
    if($request->hasParam('cedula')){          
      $cedula = trim($request->getParam('cedula'));          
      $nombre_estado = $this->TPersona->nombre_estado($cedula);
      $persona = TPersona::first(array('conditions' => array('cedula' => $cedula)));
      $fullname = $persona['apellidos']. "," . $persona['nombres'];
      $this->vista->set('persona', $cedula);
      $this->vista->set('fullname', $fullname);
      $tipo_per= TTipoPersona::nombre($persona['cod_tipo_per']);
    }else{
      $cod_programa = $request->getParam('cod_programa', TPrograma::max());  
      $this->vista->set('cod_programa', $cod_programa);
    }
    
    switch ($request->getParam('cambio')) {
        case "estado":
            $nombre_cambio="ESTADO";            
            $this->vista->set('persona', $nombre_estado);
            $this->vista->set('auditoria', 'Estado');            
            break;
        case "cedula":
            $nombre_cambio="DOC. ID";
            $this->vista->set('auditoria', 'Doc. ID');
            break;        
        case "rol":
            $nombre_cambio="ROL";
            $this->vista->set('persona', $tipo_per);
            $this->vista->set('auditoria', 'Rol');
            break;        
    }
    
    $cambios = $this->Auditoria->cambios_estudiante($cedula,$cod_programa,$nombre_cambio);
    
    if(!empty($cambios)){
          $this->vista->addJS('jquery.dataTable');
          //$cambios = $this->homogenizar_campos_auditables($cambios, 'nombre_estado');
        }
        
    $this->vista->set('cambios', $cambios);
    $this->vista->display();
    
    }
    
    
    function view_all($params,$request){
      
      
      $cedula = trim($request->getParam('cedula'));          
      $nombre_estado = $this->TPersona->nombre_estado($cedula);
      $persona = TPersona::first(array('conditions' => array('cedula' => $cedula)));
      $fullname = $persona['apellidos']. "," . $persona['nombres'];
      
      $tipo_per= TTipoPersona::nombre($persona['cod_tipo_per']);
      $cod_programa = $request->getParam('cod_programa', TPrograma::max());  
      
      $cambios_estados = $this->Auditoria->cambios_estudiante($cedula,null,'ESTADO');
      $cambios_cedula = $this->Auditoria->cambios_estudiante($cedula,null,'DOC. ID');
      $cambios_rol = $this->Auditoria->cambios_estudiante($cedula,null,'ROL');
    
      $this->vista->addJS('jquery.dataTable');

      $this->vista->set('cod_programa', $cod_programa);
      $this->vista->set('cedula', $cedula);
      $this->vista->set('fullname', $fullname);
      $this->vista->set('estado', $nombre_estado);
      $this->vista->set('rol', $tipo_per);    
      $this->vista->set('cambios_estado', $cambios_estados);
      $this->vista->set('cambios_cedula', $cambios_cedula);
      $this->vista->set('cambios_rol', $cambios_rol);
      $this->vista->set('all', 'all_cambios');
      $this->vista->display('view');
    
    }
        
    
    
  }
?>
