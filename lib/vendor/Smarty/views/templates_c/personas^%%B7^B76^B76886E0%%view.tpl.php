<?php /* Smarty version 2.6.26, created on 2011-11-30 14:10:38
         compiled from modules/estudiantes_notificaciones/templates/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_partial', 'modules/estudiantes_notificaciones/templates/view.tpl', 15, false),)), $this); ?>
<h1>Listado de Notificaciones</h1>
<?php if (isset ( $this->_tpl_vars['cedula'] )): ?>
<h2><?php echo $this->_tpl_vars['cedula']; ?>
-<?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
<?php elseif (isset ( $this->_tpl_vars['global'] ) && $this->_tpl_vars['global'] == 1): ?>
<h2>A todos los participantes</h2>
<?php elseif (isset ( $this->_tpl_vars['cod_curso'] )): ?>
<h2>Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h2>
<?php elseif (isset ( $this->_tpl_vars['cod_grupo'] )): ?>
<h2> Grupo <?php echo $this->_tpl_vars['cod_grupo']; ?>
</h2>
<?php endif; ?>

<div id="panel-enotificaciones">
	
	<div class="rtoolbar"><a href="#" id="link-nuevaNotificacion" class="link-add rlink"><span class="icon"></span>Nueva Notificaci&oacute;n</a></div>
	 <?php echo smarty_function_include_partial(array('file' => 'add.tpl','module' => 'estudiantes_notificaciones'), $this);?>

   <?php echo smarty_function_include_partial(array('file' => '_notificaciones.tpl','module' => 'estudiantes_notificaciones'), $this);?>

    
</div>