<?php

 /**
  * Clase SalonesController
  */
 class SalonesController extends Controller {

   /**
    * Constructor de la Clase SalonesController
	  */
   function setup() {
     $this->includeModel('TSede','TSalones');
     $this->vista->setTitle('Salones');
   }

   function index($params,$request) {
     
     $this->vista->addJS('jquery.dataTable');
     $salones=TSalones::all();
     $this->vista->set('salones',$salones);
      
     $sedes = TSede::all();
     $this->vista->set('sedes',$sedes);
     if (!is_blank($request->getParam('message'))){
      $this->vista->set('message',$request->getParam('message'));  
     }
     
     $this->vista->display();
   }
   
   function create($params,$request){
			if(!$this->AppUser->hasCredential('horario.edit'))
				$this->vista->acceso_restringido ();
			if(!empty($params['salon'])){
        $salon = $request->getParam('salon');
        $sede = $request->getParam('sede');
        $edificio = $request->getParam('edificio');
        $message = "El salon $salon en el edificio $edificio fue creado con Exito";
				TSalones::crear($params['salon']);
			  redirect_to ('salones','index', array('message'	=>	$message));
			}
    }
    
 }
?>
