<?php
   class EstudiantesMovimientosController extends Controller{
     
     function setup(){
       $this->includeModel('MovimientoEstudiante');
       $this->MovimientoEstudiante = new MovimientoEstudiante();
     }
     
     function index($params, $request){
      $cod_programa = $request->getParam('cod_programa', TPrograma::max());
      if(!$request->hasParam('cod_programa')){
          $this->vista->set('cod_programa', $cod_programa);
      }
      
      $mov = $this->MovimientoEstudiante->all($cod_programa);
      $this->vista->set('total',0);
      $this->vista->set('mov', $mov);
      $this->vista->display();
    }
    
    function view($params, $request){
      $this->vista->addJS("jquery.dataTable");
      if(!$request->hasParam('fecha')){
        return $this->redirect('index');
      }
      $fecha = $request->getParam('fecha');
      
      $ingresos = $this->MovimientoEstudiante->buscarIngresosPorFecha($fecha);
      $bloqueados = $this->MovimientoEstudiante->buscarBloqueadosPorFecha($fecha);
      
      $this->vista->set('ingresos',$ingresos);
      $this->vista->set('bloqueados',$bloqueados);
      
      $this->vista->display();
    }
   }
?>
