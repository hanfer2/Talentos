<?php /* Smarty version 2.6.26, created on 2011-06-30 14:33:41
         compiled from templates/_public/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_menu', 'templates/_public/menu.tpl', 5, false),array('function', 'url_for', 'templates/_public/menu.tpl', 21, false),)), $this); ?>
<div class="ui-sidebar-menu">
  <ul id="top-menubar" class="sf-menu jm-menu ui-state-default">
		<?php if (is_user_login ( COD_TIPO_DIGITA_ICFES )): ?>
      <?php echo smarty_function_include_menu(array('file' => 'digita_icfes'), $this);?>

				<?php elseif (is_professor_login ( )): ?>
      <?php echo smarty_function_include_menu(array('file' => 'docente'), $this);?>

				<?php elseif (is_student_login ( )): ?>
      <?php echo smarty_function_include_menu(array('file' => 'estudiante'), $this);?>

		<?php elseif (is_user_login ( COD_TIPO_VISITANTE_1 )): ?>
      <?php echo smarty_function_include_menu(array('file' => 'visitante'), $this);?>

		    <?php else: ?>
       <?php echo smarty_function_include_menu(array('file' => 'admin'), $this);?>

    <?php endif; ?>
    

    <li class="jm-rightItem">
			<a href="<?php echo smarty_function_url_for(array('controller' => 'sesion','action' => 'salir'), $this);?>
" title="Cerrar Sesión"><span class="ui-icon ui-icon-power"></span>Salir</a>
		</li>
		<?php if (is_admin_login ( ) || is_coordinator_login ( )): ?>
			<li class="jm-rightItem">
				<a href="<?php echo smarty_function_url_for(array('controller' => 'personas','action' => 'find'), $this);?>
" title="Buscar Usuario"><span class="ui-icon ui-icon-search"></span>Buscar</a>
			</li>
		<?php endif; ?>
		<li class="jm-clear">&nbsp;</li>
  </ul>
  <div class="clear"></div>
</div>
<div class="clear"></div>
