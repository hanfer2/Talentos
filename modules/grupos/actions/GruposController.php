<?php

 /**
  * Clase GruposController extendida de Controller
  */
 class GruposController extends Controller {

   /**
    * Constructor de la Clase GruposController
	*/
   function GruposController() {
     parent::Controller();
     $this->includeModel('TGrupo');
   }

   /**
    * Muestra todos los grupos segun un programa y unas condiciones dadas
	*/
   function index() {
     $this->vista->addJS('jquery.dataTable','jquery.fancybox','jquery.alphanumeric');
     $this->vista->addCSS('jquery.fancybox');
     if(is_blank($this->params['cod_programa']))
       $this->vista->mostrar('find');
     else {
       $cod_programa = $this->params['cod_programa'];
       $conditions = array('cod_programa' =>$this->params[cod_programa],'tipo'=> ($this->params['tipo']=='-')?null:$this->params['tipo']);
       $grupos = TGrupo::all(array('conditions'=>$conditions));
       $this->vista->set(array('grupos'=>$grupos,'cod_programa'=>$cod_programa, 'tipo'=>$this->params['tipo']));
       $this->vista->mostrar(__FUNCTION__);
     }
   }

   /**
    * Lista de grupos segun el programa especificado
	*/
   function grupos_segun_programa() {
     echo html_select('cod_grupo', TGrupo::toSQL($this->params['cod_programa']));
   }

   /**
    * Lista de cursos segun el programa especificado
	*/
   function cursos_segun_programa($params) {
		 $cursos = TPrograma::cursos($params['cod_programa'], $params['tipo']);
		 $cursos = array_merge(multisize_param_assoc_array($this->params['extra']) , $cursos);

		 echo JSON::encode($cursos);
//     echo html_select_with('cod_curso', $cursos, $this->params['extra']);
   }

   /**
    * Adiciona
	*/
   function add() {
     $this->vista->addJS('jquery.alphanumeric');
     $this->vista->mostrar(__FUNCTION__);
   }

   /**
    * Crea un grupo dentro de un programa
	*/
   function create() {
     $grupo = $this->params['grupo'];
     $existeGrupo = TGrupo::exists($grupo['grupo'],$grupo['subgrupo'],$grupo['cod_programa'],$grupo['tipo']);
     if($existeGrupo)
       echo "<span class='ui-state-error-text bold'>ESTE GRUPO YA EXISTE</span>";
     else {
       TGrupo::crear($grupo);
       echo "GRUPO CREADO CON ÉXITO";
     }
   }

   /**
    * Muestra los estudiantes inscritos en un grupo
	*/
   function view() {
     $this->vista->addJS('jquery.fancybox','jquery.dataTable','jquery.pnotify');
     $this->vista->addCSS('jquery.fancybox','jquery.pnotify');
     if(is_blank($this->params['cod_grupo'])) {
       $this->vista->mostrar('form_consultarGrupo');
     }else {
       $cod_grupo = $this->params['cod_grupo'];
       $estudiantes = TGrupo::inscritos($cod_grupo);
       $this->vista->set(array('estudiantes'=>$estudiantes,'cod_grupo'=>$cod_grupo));
       $this->vista->mostrar('view');
     }

   }

   /**
    * Registra a un estudiante dentro de un grupo
	*
	* @return
	*/
   function adicionarEstudiantes() {
     if(is_blank($this->params['cod_grupo']) || is_blank($this->params['usuario']['cedula'])) {
       redirect_to('grupos');
     }else {
       $cod_grupo = $this->params['cod_grupo'];
       $cedula = $this->params['usuario']['cedula'];
       require_once CARPETA_MODELOS . 'TEstudiante.inc';
       $nombre_persona = TEstudiante::nombre($cedula);
       if(is_blank($nombre_persona)) {
         echo JSON::encode(array('text'=>'Estudiante No Hallado'));
         return;
       }
       $tipoGrupo = TGrupo::get($cod_grupo,'tipo');
       $cod_grupoEstudiante = TEstudiante::grupo($cedula, $tipo['tipo']);
       if(!empty($cod_grupoEstudiante)) {
         echo JSON::encode(array('text'=>"El Estudiante ya se encuentra registrado en el grupo ".TGrupo::nombre($cod_grupoEstudiante['cod_grupo'])));
         return;
       }
       $result = array('ok'=>true,'text'=>array('cedula'=>$cedula,'nombre'=>$nombre_persona));
       echo JSON::encode($result);
     }
   }

   /**
    *
	*/
   function load() {
     echo html_select('cod_grupo',to_html_array( TGrupo::toSQL($this->params['grupo'])));
   }
 }
?>
