<?php

class HorariosEspecialesController extends Controller{
  
  function setup(){
    $this->includeModel("CursoEspecial");
    $this->CursoEspecial = new CursoEspecial();
    $this->vista->setTitle("Horarios Especiales");
  }
  

  function view($params, $request){
    $this->vista->addJS('jquery.fullcalendar');
    $this->vista->addCSS('jquery.fullcalendar');
    if($request->hasParam('cod_curso')){
      
    }
    $this->vista->display();
  }
  
}
