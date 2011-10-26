<?php /* Smarty version 2.6.26, created on 2011-10-20 15:55:31
         compiled from modules/asistencias/templates/componentes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/asistencias/templates/componentes.tpl', 7, false),array('function', 'include_partial', 'modules/asistencias/templates/componentes.tpl', 68, false),array('modifier', 'escape', 'modules/asistencias/templates/componentes.tpl', 44, false),array('modifier', 'default', 'modules/asistencias/templates/componentes.tpl', 45, false),array('modifier', 'date_format', 'modules/asistencias/templates/componentes.tpl', 64, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['codPrograma'] ) && $this->_tpl_vars['cod_curso'] != null): ?>
	
<?php elseif (empty ( $this->_tpl_vars['componentes'] )): ?>
	<p>No hay Inasistencias Reportadas</p>
<?php else: ?>

    <?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Listado de Inasistencias'), $this);?>

	<div class='ajax-response' id='ajax-listadoDeInasistencias'></div>

<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Componentes</h1>
 
  <table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
<thead>
	<tr>
	<th  rowspan='3'>componentes</th>
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
		<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componentes']):
?>
      <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['componentes']['nombre_componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['excusamedica'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['calamidad'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['estudio'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['transporte'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
       
      <td class='total total-asistenciasJustificadas'></td>
       
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['nojustificada'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['trabajo'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['transportemenos'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        
   <td class='total total-asistenciasInjustificadas'></td>
   
       <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['componentes']['totalinasistencia'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
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
