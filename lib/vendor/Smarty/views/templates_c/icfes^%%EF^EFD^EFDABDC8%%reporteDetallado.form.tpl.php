<?php /* Smarty version 2.6.26, created on 2011-07-12 09:29:46
         compiled from modules/icfes/templates/reporteDetallado.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/icfes/templates/reporteDetallado.form.tpl', 2, false),array('function', 'html_select', 'modules/icfes/templates/reporteDetallado.form.tpl', 32, false),array('modifier', 'underscorify', 'modules/icfes/templates/reporteDetallado.form.tpl', 5, false),array('modifier', 'lower', 'modules/icfes/templates/reporteDetallado.form.tpl', 5, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programas_icfes','title' => 'Reporte Icfes General'), $this);?>

	<div class='ajax-response' id='ajax-form-reporteIcfesGeneral'></div>
<?php else: ?>
<div id='tabs-ReporteDetallado' class='tabs non-printable prueba-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
' >
  <!-- tabs -->
  <ul>
    <li><a href='#form-reportePorComponentes'>Por &Aacute;reas</a></li>
    <li><a href='#form-reportePorCompetencias'>Por Competencias</a></li>
    <li><a href='#form-reportePorCualitativos'>Por Componentes</a></li>
  </ul>
  <!-- por componentes -->
  <div class='ui-widget decorated' id='form-reportePorComponentes'>
    <h3>Reporte por &Aacute;reas de Pruebas Icfes y Simulacros</h3>
    <div class='ui-form'>
	    <input type=hidden name=cod_prueba value='<?php echo $this->_tpl_vars['cod_prueba']; ?>
' />
	    <input type=hidden name=cod_programa value='<?php echo $this->_tpl_vars['cod_programa']; ?>
' />
      <div class="ui-field boxed field-tipoReporte">
	      <div>
		      <div class="inline">
		      	<input type="radio" name="componentes[tipo]" value="resumen" id='componentes_tipo_resumen' class="chk-resumen" checked="checked"/>
		      	<label for='componentes_tipo_resumen'>Resumen</label>
		      </div>
		      <div class="inline">
		        <input type="radio" name="componentes[tipo]" value="detallado" id='componentes_tipo_detallado' class="chk-detallado"/>
		        <label for='componentes_tipo_detallado'>Detallado</label>
		      </div>
       </div>
       <div>
        <div class="container-cod_curso" >
           <label for='componentes_cod_curso'>Curso</label><br/>
           <?php echo smarty_function_html_select(array('name' => 'componentes[cod_curso]','options' => $this->_tpl_vars['cursos']), $this);?>

        </div>
       </div>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
      <div class="ui-field center">
        <input type="checkbox" id='componentes_porniveles' name="componentes[porniveles]" value="1"/> 
        <label for='componentes_porniveles'>Por Niveles</label>
      </div>
      <div class="ui-button-bar">
        <button id='bt-generarReporteGeneralPorComponentes'>Aceptar</button>
      </div>
    </div>
    <div id='ajax-reporteInformeGeneral-componentes' class='ajax-response'></div>
  </div>

  <!-- por competencias -->
  <div class='ui-widget decorated' id='form-reportePorCompetencias'>
    <h3>Reporte por Competencias de Pruebas Icfes y Simulacros</h3>
    <div class='ui-form'>
	     <input type=hidden name=cod_prueba value='<?php echo $this->_tpl_vars['cod_prueba']; ?>
' />
 	     <input type=hidden name=cod_programa value='<?php echo $this->_tpl_vars['cod_programa']; ?>
' />	     
       <div class="ui-field boxed field-tipoReporte">
	      <div>
		      <div class="inline">
		      	<input type="radio" name="competencias[tipo]" value="resumen" id='competencias_tipo_resumen' class="chk-resumen" checked="checked"/> 
		      	<label for='competencias_tipo_resumen'>Resumen</label>
		      </div>
		      <div class="inline">
		        <input type="radio" name="competencias[tipo]" value="detallado" id='competencias_tipo_detallado'  class="chk-detallado"/>
		        <label for='competencias_tipo_detallado'>Detallado</label>
		      </div>
       </div>
       <div>
        <div class="container-cod_curso" >
           <label>Curso</label><br/><?php echo smarty_function_html_select(array('name' => 'competencias[cod_curso]','options' => $this->_tpl_vars['cursos']), $this);?>

        </div>
       </div>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
      <div class="ui-button-bar">
        <button id='bt-generarReporteGeneralPorCompetencias'>Aceptar</button>
      </div>
    </div>
    <div id='ajax-reporteInformeGeneral-competencias' class='ajax-response'></div>
  </div> <!-- FIN form-reportePorCompetencias-->
  
  <!-- por cualitativos -->
  <div class='ui-widget decorated' id='form-reportePorCualitativos'>
    <h3>Reporte por Componentes de Pruebas Icfes y Simulacros</h3>
    <div class='ui-form'>
	     <input type=hidden name=cod_prueba value='<?php echo $this->_tpl_vars['cod_prueba']; ?>
' />
 	     <input type=hidden name=cod_programa value='<?php echo $this->_tpl_vars['cod_programa']; ?>
' />	     
       <div class="ui-field boxed field-tipoReporte">
	      <div>
		      <div class="inline">
		      	<input type="radio" name="cualitativos[tipo]" value="resumen" id='cualitativos_tipo_resumen' class="chk-resumen" checked="checked"/> 
		      	<label for='cualitativos_tipo_resumen'>Resumen</label>
		      </div>
		      <div class="inline">
		        <input type="radio" name="cualitativos[tipo]" value="detallado" id='cualitativos_tipo_detallado'  class="chk-detallado"/>
		        <label for='cualitativos_tipo_detallado'>Detallado</label>
		      </div>
       </div>
       <div>
        <div class="container-cod_curso" >
           <label>Curso</label><br/><?php echo smarty_function_html_select(array('name' => 'cualitativos[cod_curso]','options' => $this->_tpl_vars['cursos']), $this);?>

        </div>
       </div>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
      <div class="ui-button-bar">
        <button id='bt-generarReporteGeneralPorCualitativos'>Aceptar</button>
      </div>
    </div>
    <div id='ajax-reporteInformeGeneral-cualitativos' class='ajax-response'></div>
  </div> <!-- FIN form-reportePorCompetencias-->
  
</div>

<?php endif; ?>
