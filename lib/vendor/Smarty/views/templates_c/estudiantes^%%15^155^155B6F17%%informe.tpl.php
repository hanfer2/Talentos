<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/estudiantes/templates/informe.tpl', 2, false),array('function', 'nombre_programa', 'modules/estudiantes/templates/informe.tpl', 8, false),array('function', 'include_partial', 'modules/estudiantes/templates/informe.tpl', 26, false),array('modifier', 'date_format', 'modules/estudiantes/templates/informe.tpl', 9, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Informe de Participantes'), $this);?>

	<div class='ajax-response' id='ajax-informe-participantes'></div>
<?php else: ?>

<div class='ui-widget decorated' id="wPanel-reporte-Participantes">
	<h1>Informe de Participantes</h1>
	<h2><?php echo smarty_function_nombre_programa(array(), $this);?>
</h2>
	<h3><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</h3>
	<h4>Total Estudiantes <?php echo $this->_tpl_vars['oInforme']->nombreEstadoEstudiantes; ?>
S: <?php echo $this->_tpl_vars['oInforme']->total; ?>
</h4>
	<div class='ui-toolbar'><a href='#' class='link-print'>Imprimir</a></div>
	
	<div id='wrapper-reporte-participantes' class="wp frm-9">
		<div class="sidebar wp-l frm-1-5 sb-r" id="menu-reporte-Participantes">
			<h2 class="ui-state-default">Men&uacute;</h2>
			<a href="#reporte-Edad">Edad</a>
			<a href="#reporte-Genero">G&eacute;nero</a>
			<a href="#reporte-Estrato">Estrato</a>
			<a href="#reporte-Comuna">Comuna</a>
			<a href="#reporte-ComunaPredominante" title="Comuna Predominante">Comuna Predom.</a>
			<a href="#reporte-Excepcion">Est. Excepci&oacute;n</a>
			<a href="#reporte-Colegio">Colegios</a>
		</div>
		
		<div id="content-reporte-participantes" class="panel-main-content wp-l frm-7">
			<div class="p-content-item " id="#reporte-Default"><?php echo smarty_function_include_partial(array('file' => "informe/default"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Edad"><?php echo smarty_function_include_partial(array('file' => "informe/edades"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Genero"><?php echo smarty_function_include_partial(array('file' => "informe/generos"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Estrato"><?php echo smarty_function_include_partial(array('file' => "informe/estratos"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Comuna"><?php echo smarty_function_include_partial(array('file' => "informe/comunas"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-ComunaPredominante"><?php echo smarty_function_include_partial(array('file' => "informe/comunas_cursos"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Excepcion"><?php echo smarty_function_include_partial(array('file' => "informe/excepciones"), $this);?>
</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Colegio"><?php echo smarty_function_include_partial(array('file' => "informe/colegios"), $this);?>
</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="date-report"> Generado: <span class="date"><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>
</span></div>
</div>
<?php endif; ?>