<?php

 class EstudiantesNotificacionesController extends Controller {

   function __construct() {
     parent::__construct();
     parent::includeModel('TEstudiante','EstudianteNotificacion');
     $this->vista->setTitle('Registro de Notificaciones');
     $this->Notificaciones = new EstudianteNotificacion();
   }
   
	/**
	 * Agrega nuevas notificaciones a un estudiante
	 */
	 function add($params){
		 if(isset($params['cedula'])){
			 $this->Notificaciones->add($params['cedula'], $params['notificacion']);
			 $this->_notificaciones($params);
		 }elseif($params['global'] == 1){
       $this->add_global($params);
     }elseif($params['cod_curso']){
       $this->add_c($params);
     }elseif($params['cod_grupo']){
       $this->add_g($params);
     }
	 }
	 
	 /**
    * Muestra como una alerta, las notificaciones asociadas a un estudiante.
	  * @see view
	  */
	 function _notificaciones($params){
     $notificaciones = null;
		 if($params['cedula']){
			$notificaciones = $this->Notificaciones->por_cedula($params['cedula']);
      
   
      
		 }elseif($params['global'] == 1){
       $notificaciones = $this->Notificaciones->globales();
     }
     elseif($params['cod_curso']){
			$notificaciones = $this->Notificaciones->por_curso($params['cod_curso']);
		 }
     elseif($params['cod_grupo']){
			$notificaciones = $this->Notificaciones->por_grupo($params['cod_grupo']);
		 }
     
     $this->vista->set('notificaciones', $notificaciones);
     $this->vista->display(__FUNCTION__);
	 }
	 
	 /**
	  * Muestra el listado de notificaciones registradas para un usuario.
	  */
	 function view($params)
   {
    
     
     if($params['cedula']){
       
        $cedula = $params['cedula'];
        
        
        //echo $cedula;
        $notificaciones = $this->Notificaciones->por_cedula($cedula);
        
       //echo ( $this->vista->set('link_delete', 'cedula-'.$params['cedula'])); 
        
        $this->vista->set('link_delete', 'cedula-'.$params['cedula']);
     }
     elseif($params['global'] == 1)
     {
       $notificaciones = $this->Notificaciones->globales();
       $this->vista->set('link_delete', 'g');
     }
     elseif($params['cod_curso'])
     {
        $cod_curso = $params['cod_curso'];
        $notificaciones = $this->Notificaciones->por_curso($cod_curso);
        $this->vista->set('link_delete', 'cod_curso-'.$params['cod_curso']);
     }
     elseif($params['cod_grupo'])
     {
        $cod_grupo = $params['cod_grupo'];
        $notificaciones = $this->Notificaciones->por_grupo($cod_grupo);
        $this->vista->set('link_delete', 'cod_grupo-'.$params['cod_grupo']);
     }
     $this->vista->set('notificaciones', $notificaciones);
     $this->vista->display();
	 }
	 
	 function delete($params){
		 if(!is_admin_login())
			return $this->vista->acceso_restringido();
     if($params['global'] == 1){
      $status = $this->Notificaciones->delete_global($params['cod_mensaje']);
    }
     else{
        // $codigoInterno = $this->Notificaciones->buscarInterno($params['val']);
     
      $status = $this->Notificaciones->delete($params['param'], $params['val'], $params['cod_mensaje']);
    }
		 if($status['status']){
				$this->_notificaciones($params);
		 }
	 }
   /**
    * Permite agregar notificaciones a todo un curso 
    */
   function add_c($params){
      $this->Notificaciones->agregar_por_curso($params['cod_curso'], $params['notificacion']);
      $this->_notificaciones($params);
   }
   /**
    * Permite agregar notificaciones a todo un grupo
    */
   function add_g($params){
      $this->Notificaciones->agregar_por_grupo($params['cod_grupo'], $params['notificacion']);
      $this->_notificaciones($params);
   }
   
   function add_global($params){
     $this->Notificaciones->agregar_global($params['notificacion']);
     $this->_notificaciones($params);
   }
	 
 }
?>
