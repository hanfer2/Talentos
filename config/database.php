<?php
  /***** DB *****/
  $siat_const->set('siat_db_user','dintev');
  $siat_const->set('siat_db_passwd','dintev');
  $siat_const->set('siat_db_host','localhost');
  $siat_const->set('siat_db_port','5432');
  $siat_const->set('siat_db_dbname','talentos_produccion');
  
  
 $config = &Config::getInstance();
 
 $config->updateCurrentModel('default');
 $config->add('primary_key','codigo');
   
  /**** PERSONAS ****/
 $config->updateCurrentModel('TPersona');
 $config->add('tablename','a_persona');
 $config->add('order','apellidos');
 $config->add('primary_key','cod_interno');
 $config->add('EstadoCivil','p_estados_civiles');
 $config->add('Password','p_passwords');
 $config->add('Desplazado','pe_desplazados');
 $config->add('Embarazo','pe_embarazos');
 
 $config->updateCurrentModel('Notificacion');
 $config->add('tablename','pe_notificaciones');
 
 $config->updateCurrentModel('EstudianteNotificacion');
 $config->add('tablename','pe_notificaciones_estudiantes');
 $config->add('viewname', 'v_estudiantes_notificaciones');
 $config->add('Grupo', 'pe_notificaciones_grupos');
 $config->add('Curso', 'pe_notificaciones_cursos');

 /** ESTUDIANTES ** */
 $config->updateCurrentModel('TEstudiante');
 $config->inheritsFrom('TPersona');
 $config->add('viewname','v_estudiantes');
 $config->add('bloqueados','a_bloqueados');
 $config->add('CausaBloqueo','pe_causas_bloqueo');
 $config->add('TPrograma','v_estudiantes_programas');
 $config->add('Inactivos','v_estudiantes_inactivos');
 $config->add('TGrupo','v_estudiantes_grupos');
 $config->add('TCurso','a_estudiantes_grupos');
 $config->add('TUniversidad','pe_estudiantes_universidades');
 $config->add('TColegio','pe_colegios_estudiantes');
 $config->add('V-Colegio','v_estudiantes_colegios');
 $config->add('V-Observacion','v_estudiantes_observaciones');
 /**  Egresados **/
 $config->updateCurrentModel('TEgresado');
 $config->inheritsFrom('TEstudiante');
 $config->add('tablename','v_egresados');
 $config->add('TUniversidad','v_egresados_universidades');
 $config->add('Trabajo','pe_egresados_trabajo');
 $config->reset('viewname');
 /** TDocente **/
 $config->updateCurrentModel('TDocente');
 $config->inheritsFrom('TPersona');
 $config->add('tablename','v_docentes');
 $config->add('order','fullname');
 $config->add('TCurso','v_cursos_docentes');
 $config->reset('viewname');
 /** Componentes **/
 $config->updateCurrentModel('TComponente');
 $config->add('tablename','a_componentes');
 $config->add('TGrupo','cu_componentes_cursos');
 $config->add('TPrograma','v_componentes_programas');
 /** Asistencia **/
 $config->updateCurrentModel('TAsistencia');
 $config->add('tablename','cu_asistencias');
 $config->add('Inasistencias','v_inasistencias');
 $config->add('V-Inasistencias','vi_inasistencias');
 $config->add('R-Inasistencias','t_reporte_inasistencias');
 $config->add('R-ClasesAsistidas','t_reporte_asistencias');
 
 /** Clase **/
 $config->updateCurrentModel('TClase');
 $config->add('tablename','cu_clases');
 $config->add('TAsistencia',$config->getAttribute('TAsistencia'));
 /** Programas **/
 $config->updateCurrentModel('TPrograma');
 $config->add('tablename','a_programas');
 $config->add('order','codigo DESC');
 /** Grupos **/
 $config->updateCurrentModel('TGrupo');
 $config->add('tablename','a_grupos');
 $config->add('viewname','v_grupo');
 $config->add('order','tipo desc, grupo, subgrupo');
 /** Curso **/
 $config->updateCurrentModel('TCurso');
 $config->add('Horario','cu_horarios');
 $config->add('TClase',$config->getAttribute('TClase'));
 $config->add('Vista-Horario','v_horarios');

 /** Sedes**/
 $config->updateCurrentModel('TSede');
 $config->add('tablename','re_sedes');
 /** Colegios ***/
 $config->updateCurrentModel('TColegio');
 $config->add('tablename','re_colegios');
 $config->add('TEstudiante','pe_colegios_estudiantes');
 /** Universidades ***/
 $config->updateCurrentModel('TUniversidad');
 $config->add('tablename','re_universidades');
 $config->add('viewname','v_universidades');
 $config->add('TCiudad','v_ciudades_con_universidades');
 
 
 /** Carreras **/
 $config->updateCurrentModel('TCarrera');
 $config->add('tablename','re_carreras');
 /** Ciudades ***/
 $config->updateCurrentModel('TCiudad');
 $config->add('tablename','v_ciudades_colombianas');
 $config->add('order','nombre');
 /** Barrios ***/
 $config->updateCurrentModel('TBarrio');
 $config->add('tablename', 'rg_barrios');
 /** Colegios**/
 $config->updateCurrentModel('TColegio');
 $config->add('tablename','re_colegios');
 /** Discapacidades**/
 $config->updateCurrentModel('TDiscapacidad');
 $config->add('tablename','p_discapacidades');
 /** Motivos Inasistencias**/
 $config->add('TMotivoInasistencia','tablename','pe_motivos_inasistencias');
 /** Observaciones **/
 $config->updateCurrentModel('TObservacion');
 $config->add('tablename','pe_observaciones');
 $config->add('conteo','vi_estudiantes_observaciones');
  /** Etnias**/
 $config->updateCurrentModel('TEtnia');
 $config->add('tablename','p_etnias');
 /** Tipo Persona ***/
 $config->updateCurrentModel('TTipoPersona');
 $config->add('tablename','p_tipos_personas');
 /** Tipo Cedula***/
 $config->updateCurrentModel('TTipoCedula');
 $config->add('tablename','p_tipos_cedulas');
 /** Estado Civil ***/
 $config->updateCurrentModel('TEstadoCivil');
 $config->add('tablename','p_estados_civiles');
 
 /** Estado **/
 $config->updateCurrentModel('TEstado');
 $config->add('tablename','a_estados');



 /** Icfes ***/
 $config->updateCurrentModel('TIcfes');
 $config->add('tablename','a_estudiantes_icfes');
 $config->add('Respuesta','i_respuestas');
 $config->add('order','');
 
 $config->updateCurrentModel('TEstudianteIcfes');
 $config->add('tablename','a_estudiantes_icfes');
 /** Tipos Icfes ***/
 $config->updateCurrentModel('ITipo');
 $config->add('tablename','i_tipos');
 $config->add('order','fecha');
 //Icfes Componentes
 $config->updateCurrentModel('IComponente');
 $config->add('tablename', 'i_componentes');
 //Icfes Competencias
 $config->updateCurrentModel('ICompetencia');
 $config->add('tablename','i_competencias');
 $config->add('Puntaje','i_puntajes_competencias');
 $config->add('V-Puntaje','v_puntajes_competencias');
 
 $config->add('IComponenteCualitativo','tablename', 'i_cualitativos'); //<== DEBE SER ELIMINADA
 
 $config->updateCurrentModel('ICualitativo');
 $config->add('tablename', 'i_cualitativos');
 $config->add('Puntaje','i_puntajes_cualitativos');
 $config->add('V-Puntaje','v_puntajes_cualitativos');
 
 $config->updateCurrentModel('ICuestionario');
 $config->add('Pregunta','i_preguntas');
 $config->add('V-Pregunta','v_preguntas');
 $config->add('Respuesta','i_respuestas');
 $config->add('V-Respuesta','v_respuestas');
 $config->add('Diligenciados','i_cuestionarios_diligenciados');
 
 
 //Icfes Idioma
 $config->updateCurrentModel("IIdioma");
 $config->add('tablename','i_idiomas');
 //Icfes Interdisciplinar
 $config->updateCurrentModel("IInterdisciplinar");
 $config->add('tablename','i_interdisciplinarias');
  
  
  
  
  
?>
