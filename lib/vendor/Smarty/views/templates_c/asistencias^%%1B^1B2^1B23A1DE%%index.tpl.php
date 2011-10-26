<?php /* Smarty version 2.6.26, created on 2011-10-10 17:13:03
         compiled from ./modules/asistencias/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/asistencias/templates//index.tpl', 29, false),array('function', 'include_partial', './modules/asistencias/templates//index.tpl', 45, false),array('modifier', 'date_format', './modules/asistencias/templates//index.tpl', 32, false),)), $this); ?>
<!-- <?php ob_start(); ?>
	<?php if (is_super_admin_login ( )): ?>-->
	<a href="#" id="link-registrarNuevoPlan">Registrar Nuevo PNAT</a>
	<!-- <?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('links', ob_get_contents());ob_end_clean(); ?>-->
<?php if (empty ( $this->_tpl_vars['grupo'] )): ?>
	<!-- <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_config[0]['vars']['EMPTY_RESULTS_FILE'], 'smarty_include_vars' => array('links' => $this->_tpl_vars['links'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->
  <?php echo 'T.T'; ?>

<?php else: ?>

<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Grupo</h1>
 
  <table class="table dataTable">
    <thead>
      <tr><th rowspan="2" >GRUPO</th>
       <th rowspan="2">INASISTENCIAS</th>
       <!--  <th colspan="2">1r Semestre</th><th colspan="2">2r Semestre</th>
        <th rowspan="2">Activo</th>-->
      </tr>
     <!-- <tr>
        <th>Fecha Inicio</th><th>Fecha Cierre</th>
        <th>Fecha Inicio</th><th>Fecha Cierre</th>
      </tr>-->
    </thead>
    <tbody>
			<?php $_from = $this->_tpl_vars['grupo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grupo']):
?>
      <tr>
        <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['grupo']['grupo'],'action' => 'indexCursos','grupo' => $this->_tpl_vars['grupo']['grupo']), $this);?>
</td>
        <td><?php echo $this->_tpl_vars['grupo']['inasistencias']; ?>
</td>
       <!-- 
        <td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['grupo']['fecha_inicio_1'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
        <td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['grupo']['fecha_cierre_1'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
        <td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['grupo']['fecha_inicio_2'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
        <td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['grupo']['fecha_cierre_2'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
        <td><?php if (date_compare ( $this->_tpl_vars['grupo']['fecha_cierre_2'] , date ( "Y-M-D" ) ) < 0 && date_contains ( $this->_tpl_vars['programa']['fecha_inicio_1'] , $this->_tpl_vars['programa']['fecha_cierre_2'] )): ?>&#10004;<?php else: ?>&#10008;<?php endif; ?></td>
        -->
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
  <!--
  <div class="ui-toolbar"><?php echo $this->_tpl_vars['links']; ?>
</div>
<?php if (is_super_admin_login ( )): ?>
<?php echo smarty_function_include_partial(array('module' => 'programas','file' => "add.tpl"), $this);?>

<?php endif; ?>-->
</div>
<?php endif; ?>
