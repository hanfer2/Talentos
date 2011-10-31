<?php /* Smarty version 2.6.26, created on 2011-10-31 16:37:44
         compiled from ./modules/asistencias/templates//indexCursos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', './modules/asistencias/templates//indexCursos.tpl', 45, false),array('modifier', 'date_format', './modules/asistencias/templates//indexCursos.tpl', 59, false),array('function', 'include_partial', './modules/asistencias/templates//indexCursos.tpl', 63, false),)), $this); ?>
<!-- <?php ob_start(); ?>
	<?php if (is_super_admin_login ( )): ?>-->

	<!-- <?php endif; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('links', ob_get_contents());ob_end_clean(); ?>-->
<?php if (empty ( $this->_tpl_vars['grupo'] )): ?>
	<!-- <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_config[0]['vars']['EMPTY_RESULTS_FILE'], 'smarty_include_vars' => array('links' => $this->_tpl_vars['links'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>-->

<?php else: ?>

<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Curso grupo <?php echo $this->_tpl_vars['g']['grupo']; ?>
</h1>
 
 <table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
    <thead>
      <tr><th rowspan="3" >GRUPO</th>
 <th colspan='10'>INASISTENCIAS</th>

	</tr>
	<tr>
		<th colspan='5'>JUSTIFICADAS</th>
		<th colspan='4'>INJUSTIFICADAS</th>
		<th class='column-total' title='Total de Inasistencias' rowspan='3'>TOTAL INASISTENCIAS</th>
	</tr>
	<tr>
    
		
		<th>EXCUSA MÉDICA</th>
		<th>CALAMIDAD</th>
    <th>ESTUDIO</th>
    <th>TRANSPORTE+</th>
		<th class='column-total' title='Total de Inasistencias Justificadas'>TOTAL</th>
    
		
		<th>NO JUSTIFICADA</th>
		<th>TRABAJO</th>
    <th>TRANSPORTE-</th>
		<th class='column-total' title='Total de Inasistencias No Justificadas'>TOTAL</th>
      </tr>
    </thead>
    <tbody>
			<?php $_from = $this->_tpl_vars['grupo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grupo']):
?>
     <tr>
        <td><?php echo $this->_tpl_vars['grupo']['nombre_grupo']; ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['excusamedica'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['calamidad'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['estudio'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
         <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['transporte'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
          <td class='total total-asistenciasJustificadas'></td>
         <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['nojustificada'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
          <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['trabajo'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
           <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['transportemenos'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
             <td class='total total-asistenciasInjustificadas'></td>
            <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['grupo']['inasistencias'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
   <div class='date-report'>Generado: <span class='date'><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span></div>
  <!--
  <div class="ui-toolbar"><?php echo $this->_tpl_vars['links']; ?>
</div>
<?php if (is_super_admin_login ( )): ?>
<?php echo smarty_function_include_partial(array('module' => 'programas','file' => "add.tpl"), $this);?>

<?php endif; ?>-->
</div>
<?php endif; ?>
