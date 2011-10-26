<?php

    /**
     * Clase IPruebasController extendida de Controller
     */
	class IPruebasController extends Controller {

     /**
	  * Constructor de la Clase IPruebasController
	  */
	 function __construct() {
			parent::__construct();
			$this->includeModel('TIcfes');
			$this->vista->setTitle('Pruebas');
			$this->ITipo = new ITipo();
	 }

	 /**
	  * Listado de pruebas para el programa indicado por tipo
	  */
	 function index(){
		 $this->vista->addJS('jquery.ui.datepicker');
		 if(isset($this->params['cod_programa'])){
			 $pruebas = $this->ITipo->segunPrograma($this->params['cod_programa']);
			 $simulacros = array();
			 if($pruebas != null)
         foreach($pruebas as $prueba){
           if($prueba['tipo'] == I_TIPO_SIMULACRO )
            $simulacros[] = array('codigo'=>$prueba['codigo'], 'nombre'=>$prueba['nombre']);
          }
         
			 $tipos_icfes = array(I_TIPO_SIMULACRO=>'Simulacro', I_TIPO_OFICIAL=>'Prueba Oficial');
			 $prueba_activa = $this->AppConfig->get('I.COD_CUESTIONARIO_ACTUAL');
			 $this->vista->set('pruebas', $pruebas);
			 $this->vista->set('prueba_activa', $prueba_activa);
			 $this->vista->set('tipos_icfes', $tipos_icfes);
			 $this->vista->set('simulacros', $simulacros);
			 
		 }
		 $this->vista->display();
	 }

	 /**
	  * Simulacros sin prueba
	  */
	 function simulacros_sin_prueba(){
		 echo JSON::encode(ITipo::simulacrosSinPrueba($this->params['cod_programa']));
	 }

	 /**
	  * Crea una prueba
	  */
	 function create(){
			if($this->post['prueba']){
				ITipo::create($this->post['prueba']);
			}
	 }
	 
	 
	 function edit_visibility($params){
		 $cod_prueba = $params['pr'];
		 $visibility = $params['vis'];
		 
		 $this->ITipo->setVisible($cod_prueba, $visibility);
	 }
	 
	 function save_settings($params){
		 $cod_prueba = $params['pr'];
		 $settings = $params['settings'];
		 $this->AppConfig->set('I.COD_CUESTIONARIO_ACTUAL',$settings['i_prueba_activa'] == '-1'? null: $settings['i_prueba_activa']);
	 }
}
?>
