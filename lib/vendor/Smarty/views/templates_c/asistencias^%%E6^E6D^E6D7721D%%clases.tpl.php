<?php /* Smarty version 2.6.26, created on 2011-09-07 10:59:41
         compiled from modules/asistencias/templates/clases.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_error', 'modules/asistencias/templates/clases.tpl', 2, false),array('modifier', 'date_format', 'modules/asistencias/templates/clases.tpl', 16, false),)), $this); ?>
<?php if (! ( isset ( $this->_tpl_vars['cod_curso'] ) && isset ( $this->_tpl_vars['cod_curso'] ) )): ?>
	<?php echo smarty_function_show_error(array('message' => 'Debe especificar el curso y el componente'), $this);?>

<?php elseif (empty ( $this->_tpl_vars['clases'] )): ?>
	<div class='ui-widget decorated'>
		<h1>No se hallaron resultados</h1>
		<p>
			El componente <?php echo $this->_tpl_vars['nombre_componente']; ?>
 para el curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
 a&uacute;n no tiene clases reportadas
		</p>
	</div>
<?php else: ?>
	<h2><?php echo $this->_tpl_vars['nombre_componente']; ?>
 - Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h2>
	<div id='asistencias-clases-fechas'>
		<?php $_from = $this->_tpl_vars['clases']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['clase']):
?>
		<div class='<?php if (in_array ( $this->_tpl_vars['clase']['codigo'] , $this->_tpl_vars['clasesRegistradas'] )): ?>clase-registrada<?php else: ?>clase-noRegistrada<?php endif; ?>'>
			<input type='radio' name='cod_clase' id='clase<?php echo $this->_tpl_vars['clase']['codigo']; ?>
' value='<?php echo $this->_tpl_vars['clase']['codigo']; ?>
'/>
			<label class='date' for="clase<?php echo $this->_tpl_vars['clase']['codigo']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['clase']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 </label><span class='ui-icon ui-icon-default ui-icon-check'></span>
		</div>
		<?php endforeach; endif; unset($_from); ?>
	</div>
	<div class='ui-button-bar'>
		<button id='bt-seleccionarFechaAsistencia'>Aceptar</button>
	</div>
<?php endif; ?>