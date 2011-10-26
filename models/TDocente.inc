<?php
  /**
   * Se incluye la Clase TEstudiante
   */
 require_once "TEstudiante.inc";
   /**
   * Se incluye la Clase TComponente
   */
 require_once "TComponente.inc";
   /**
   * Se incluye la Clase TGrupo
   */
 require_once "TGrupo.inc";


 /**
  * Clase TDocente extendida de TPersona
  */
 class TDocente extends TPersona {
   
   function __construct()
   {
     parent::__construct();
     $this->tablename = $this->Config->Get(__CLASS__);
   }

     /**
      * Deuvlve los docentes ordenados por nombre completo
      *
      * @param string $options
      * @return array
      */
   function all($options=array()) {
	   if(!isset($options['order']))
	   	$options['order']='fullname ASC';
     return TBase::all(__CLASS__,$options);
   }
   
   function buscarPorPrograma($cod_programa){
     $sql = "";
     if($cod_programa == '0')
       return $this->all();
     elseif($cod_programa == '001'){
       $TDocente001 = new TDocente_Compat001();
       return $TDocente001->all();
     }else{
      $sql = "SELECT * FROM {$this->tablename} d WHERE EXISTS (SELECT * FROM ".$this->Config->Get(__CLASS__, 'TCurso')." c WHERE d.cod_interno = c.cod_interno AND cod_programa = '$cod_programa')"; 
      return $this->db->table_query($sql);
     }
   }

   /**
    * Devuelve los cursos a los que dicta clases un docente especifico
    *
    * @param int $cedula
    * @return array
    */
   function cursos($cedula=null) {
     $sql = 'SELECT DISTINCT * FROM '.Config::get(__CLASS__,'TCurso') . ' JOIN ' . $this->Config->Get('TPersona') . ' p USING (cod_interno)';
     if($cedula !== null)
       $sql .= " WHERE p.cedula = '".q($cedula)."'";
     return DB::table_query($sql);
   }
   
   function buscarPorProgramaYComponente($cod_programa, $cod_componente)
   {
	   if($cod_programa == '001'){
		   $TDocente001 = new TDocente_Compat001();
       $docentes = $TDocente001->buscarPorProgramaYComponente($cod_componente);
       return $docentes;
	   }else{
		   $sql = 'SELECT DISTINCT * FROM '.$this->Config->get('TDocente','TCurso')
            . sprintf(" WHERE cod_programa = '%s'", q($cod_programa));
		   if($cod_componente != null && $cod_componente != '0')
			   $sql .= " AND cod_componente = '".q($cod_componente)."'";
		   return $this->db->table_query($sql);
	   }
   }

   /**
    * Crea una consulta  segun las opciones especificadas
    *
    * @param array $options
    * @return string
    */
   function toSQL($options = array()) {
		 
     if($options['conCursos']===TRUE) {
        $wCursos_sql = "
          EXISTS (
          SELECT * FROM ".Config::get(__CLASS__,'TCurso')."
          WHERE ".Config::get(__CLASS__,'TCurso').".cod_interno = ".Config::get(__CLASS__).".cod_interno) ";
       if(is_null($options))
         $options = array('conditions'=>array());
       $options['conditions'] = array_merge((array)$options['conditions'], array($wCursos_sql));
     }
     if(empty($options['select']))
       $options['select'] = 'cod_interno, fullname';
		$options['order'] = ' fullname ASC ';
    return TBase::toSQL(__CLASS__, $options);
   }

	 /**
	  * Verifica si un docente imparte clases en un determinado curso
          *
	  * @param string $cedula cedula del docente
	  * @param string $cod_curso codigo del curso
	  * @return bool TRUE si el docente imparte clases en determinado curso. False de lo contrario.
	  */
	 function imparteClasesEn($cedula, $cod_curso){
		$cod_docente = TPersona::cod_interno($cedula);
		if($cod_docente === null)
		 return FALSE;
		$tablename = Config::get('TComponente','TGrupo');
		$cursos = DB::query("SELECT 1 FROM $tablename	WHERE cod_docente = $cod_docente AND cod_curso = $cod_curso");
		return !empty($cursos);
	 }

         /**
          * Devuelve el horario de las clases dictadas por un docente
          *
          * @param int $cedula
          * @return boolean
          */
	 function horario($cedula){
			$sql ="SELECT clase.codigo AS cod_clase, cod_horario, dia, sede, edificio, salon, 
										hora_inicio, hora_fin, fecha_inicio, fecha_fin, 
										horario.observaciones AS observaciones_horario, anuncios,
										cod_componente, convert(nombre_componente,'LATIN1','UTF-8') AS nombre_componente, nombre_docente, 
										fecha, cod_curso, nombre_grupo
							FROM " . Config::get('TCurso', 'Vista-Horario') . " horario".
						 " INNER JOIN ". Config::get('TClase'). " clase USING (cod_horario) ".
						 " INNER JOIN ".Config::get('TGrupo','viewname')." on cod_grupo = cod_curso
						 WHERE cod_horario IS NOT NULL AND cedula_docente = '$cedula'";

    	$horario = DB::table_query($sql);
			for($i = 0; $i < count($horario) ; $i++){

				$horario[$i]['es_docente'] = true;
			}
	  	return $horario;
    }
		
	 /**
	  * Verifica si un docente imparte clases a un estudiante
          *
	  * @param string $cedula cedula del docente
	  * @param string $cedula doc. id del estudiante
	  * @param bool
	  */
	 function imparteClasesA($cedulaDocente, $cedulaEstudiante){
		$cod_curso = TEstudiante::curso($cedulaEstudiante, null, 'cod_grupo');
		if($cod_curso === null)
			return false;
		return TDocente::imparteClasesEn($cedulaDocente, $cod_curso);
	 }
 }
 
 
 class TDocente_Compat001 extends TBase{
   
   function __construct()
   {
     parent::__construct();
     $this->tablename = $this->Config->Get('TDocente');
     $this->Config->Add(__CLASS__, 'Cursos', 'old_profe_cur');
     $this->Config->Add(__CLASS__, 'V-Cursos', 'v_old_cursos_docentes');
   }
   
   function all()
   {
     $sql = "SELECT * FROM {$this->tablename} d WHERE EXISTS (SELECT * FROM ".$this->Config->Get(__CLASS__, 'V-Cursos')." c WHERE d.cod_interno = c.cod_interno)"; 
     return $this->db->table_query($sql);
   }
   
   function buscarPorProgramaYComponente($cod_componente)
   {
      $sql = ' SELECT DISTINCT * FROM '. $this->Config->Get(__CLASS__, 'V-Cursos');
      if($cod_componente != null && $cod_componente != '0')
        $sql .= sprintf(" WHERE cod_componente = '%s'", q($cod_componente));
      return $this->db->table_query($sql);
   }
 }
?>
