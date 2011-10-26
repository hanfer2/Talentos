<?php

 class InformeEstudiantes {
	 
   var $estudiantes = 0;
	 /**
	  * codigo del programa
	  * @var string
	  */
   var $cod_programa = null;
	 /**
	  *
	  * @var array
	  */
   var $reporte = array();
   /**
    * Total de Estudiantes.
    * @var int
    */
   var $total = null;
   
   var $complementarios = array();
   

   function InformeEstudiantes($cod_programa) {
   	 $this->cod_programa = $cod_programa;
   	 
   	 $this->TEstudiante = new TEstudiante();
   	 $this->TPrograma = new TPrograma();
   	 
   	 $this->cargarEstudiantes();
		 if($this->estudiantes == null)
			return FALSE;
			
     $this->init();
     $this->procesar();
     return TRUE;
   }
   
	 function init(){

	 	$this->reporte['edades'] = array();
	 	$this->reporte['rangoEdades'] = array('M'=>0, 'm'=>0);
	 	$this->reporte['comunas'] = array();
	 	$this->reporte['comunasPredominantes'] = array();
	 	$this->reporte['generos'] = array('Hombres'=>0, 'Mujeres'=>0);
	 	$this->reporte['estratos'] = array();
	 	$this->reporte['colegios'] = array();
	 	
	 	$this->reporte['etnias'] = array('total'=>0,'NINGUNA'=>0,'estudiantes'=>array());
	 	$this->reporte['discapacidades'] = array('total'=>0,'NINGUNA'=>0,'estudiantes'=>array());
	 	$this->reporte['hijos'] = array('total'=>0,'NINGUNO'=>0,'estudiantes'=>array());
	 	$this->reporte['desplazados'] = array('total'=>0,'NINGUNO'=>0,'estudiantes'=>array());;
	 		 	
	 	$this->reporte['embarazos'] = 0;

	 	
		$this->cargarComplementarios();		
   }
   
   function cargarEstudiantes(){
		if($this->TPrograma->esta_activo($this->cod_programa)){
			$this->EstadoEstudiantes = COD_ESTADO_ACTIVO;
			$this->estudiantes = $this->TEstudiante->activos(array('cod_programa'=>$this->cod_programa));
		}else{
			$this->EstadoEstudiantes = COD_ESTADO_EGRESADO;
			$this->estudiantes = $this->TEstudiante->egresados($this->cod_programa);
		}
   	$this->total = count($this->estudiantes);
   }
   
   function cargarComplementarios(){
   	$this->complementarios['etnias'] =  DB::grouped_query(TEtnia::toSQL(), 'codigo');
   	$this->complementarios['discapacidades'] = DB::grouped_query(TDiscapacidad::toSQL(), 'codigo');
   }
   
   function sort(){
   	ksort($this->reporte['edades']);
   	ksort($this->reporte['comunas']);
   	ksort($this->reporte['estratos']);
   }
   
   function procesar(){
		if($this->estudiantes == null)
			return false;
   	foreach($this->estudiantes as $estudiante){
      $this->procesarComunas($estudiante['comuna']);
      $this->procesarEdades($estudiante['fecha_nacimiento']);
      $this->procesarGeneros($estudiante['genero']);
      $this->procesarEstratos($estudiante['estrato']);
      
      $this->procesarEtnias($estudiante);
      $this->procesarDiscapacidades($estudiante);
      $this->procesarHijos($estudiante);
   	}
   	
   	$this->procesarColegios();
 		$this->procesarEmbarazos();
 		$this->procesarDesplazados();
   	$this->calcularComunasPredominantes();

   	$this->sort();

   }
   
   function procesarEdades($fecha_nacimiento){
      $edad = TPersona::calcularEdad($fecha_nacimiento);
      if(!isset($this->reporte['edades'][$edad]))
          $this->reporte['edades'][$edad] = 0;
      $this->reporte['edades'][$edad]++;
      if($edad >= 18)
          $this->reporte['rangoEdades']['M']++;
      else
          $this->reporte['rangoEdades']['m']++;
   }
   
   function procesarComunas($comuna){
     if(!isset($this->reporte['comunas'][$comuna]))
        $this->reporte['comunas'][$comuna] = 0;
      $this->reporte['comunas'][$comuna]++;
   }
   
   function procesarGeneros($genero){
      $this->reporte['generos'][$genero=='M'? 'Hombres':'Mujeres']++;
   }
   
   function procesarEstratos($estrato){
      if(!isset($this->reporte['estratos'][$estrato]))
      	$this->reporte['estratos'][$estrato] = 0;
      $this->reporte['estratos'][$estrato]++;
   }
   
   function procesarEtnias($estudiante){
   		$etnia = $estudiante['cod_etnia'];
      if($etnia != '0'){
      	$this->reporte['etnias']['total']++;
				$etnia = $this->complementarios['etnias'][$etnia]['nombre'];
				
				if(!isset($this->reporte['etnias']['estudiantes'][$etnia]))
      		$this->reporte['etnias']['estudiantes'][$etnia] = array();
     		$this->reporte['etnias']['estudiantes'][$etnia][] = $estudiante;
      }
      else
       	$this->reporte['etnias']['NINGUNA']++;
   }
   
   function procesarDiscapacidades($estudiante){
   		$discapacidad = $estudiante['cod_discapacidad'];
      if($discapacidad != '0'){
      	$this->reporte['discapacidades']['total']++;
				$discapacidad = $this->complementarios['discapacidades'][$discapacidad]['nombre'];
				
				if(!isset($this->reporte['discapacidades']['estudiantes'][$discapacidad]))
      		$this->reporte['discapacidades']['estudiantes'][$discapacidad] = array();
     		$this->reporte['discapacidades']['estudiantes'][$discapacidad][] = $estudiante;
      }
      else
       	$this->reporte['discapacidades']['NINGUNA']++;
   }
   
   
   
   function procesarHijos($estudiante){
   		$hijos = $estudiante['hijos'];
      if($hijos != '0'){
      	$this->reporte['hijos']['total']++;
				
				if(!isset($this->reporte['hijos']['estudiantes'][$hijos]))
      		$this->reporte['hijos']['estudiantes'][$hijos] = array();
     		$this->reporte['hijos']['estudiantes'][$hijos][] = $estudiante;
      }
      else
       	$this->reporte['hijos']['NINGUN0']++;
   }
   
   function procesarEmbarazos(){
   		$select = "persona.cedula, cod_interno, persona.fullname, nombre_grupo";
   		$estudiantes = TEstudiante::listadoEnEmbarazo(array("select"=>$select, 'cod_programa'=>$this->cod_programa));
   		$this->reporte['embarazos'] = $estudiantes;
   }
   
   function procesarDesplazados(){
			$select = "persona.cedula, cod_interno, persona.fullname, nombre_grupo, ciudades.nombre AS nombre_ciudad";
   		$estudiantes = TEstudiante::desplazados(array("select"=>$select, 'cod_programa'=>$this->cod_programa, 'group_by'=>'nombre_ciudad'));
   		$this->reporte['desplazados']['estudiantes'] = $estudiantes;
   		$this->reporte['desplazados']['total'] = count($estudiantes);
   }
   
   function procesarColegios(){
			$sql = "SELECT * FROM ".Config::Get('TEstudiante', 'V-Colegio')." WHERE cod_programa = '{$this->cod_programa}'";
   		$informe = DB::table_query($sql,'cod_colegio');
   		$colegios = array('colegios'=>array(),'totales'=>array());
   		foreach($informe as $cod_colegio=>$estudiantes){
  			$colegios['colegios'][$cod_colegio] = array('info'=>array(), 'estudiantes'=>array());
  			//almacenamos la informacion del colegio
  			$colegios['colegios'][$cod_colegio]['info'] = subarray($estudiantes[0], array('nombre_colegio','tipo_colegio'));
  			
  			foreach($estudiantes as $estudiante){
  				$colegios['colegios'][$cod_colegio]['estudiantes'][] = subarray($estudiante, array('cod_interno','cedula','fullname','nombre_grupo'));  
					++$colegios['totales'][$estudiante['tipo_colegio']];
  			}
   		}
   		$this->reporte['colegios'] = $colegios;
   }
   
   function calcularComunasPredominantes(){
   		$sql = "SELECT nombre_grupo, comuna, count(*) AS cantidad ".
   					 "FROM ".Config::Get('TPersona')." persona INNER JOIN " . Config::Get('TEstudiante','TGrupo') . " USING (cod_interno)".
   					 " WHERE persona.cod_estado = '".COD_ESTADO_ACTIVO."' AND cod_programa = '{$this->cod_programa}' ".
   					 "GROUP BY nombre_grupo, comuna ORDER BY nombre_grupo, cantidad DESC";
   		$informe = DB::table_query($sql, 'nombre_grupo');
   		$this->reporte['comunasPredominantes'] = $informe;
   }
 }


?>


