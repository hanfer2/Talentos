<?php /* Smarty version 2.6.26, created on 2011-10-21 17:57:45
         compiled from ./modules/asistencias/templates//ClasesPorComponentes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/asistencias/templates//ClasesPorComponentes.tpl', 5, false),array('function', 'include_partial', './modules/asistencias/templates//ClasesPorComponentes.tpl', 66, false),array('modifier', 'escape', './modules/asistencias/templates//ClasesPorComponentes.tpl', 9, false),array('modifier', 'default', './modules/asistencias/templates//ClasesPorComponentes.tpl', 43, false),array('modifier', 'date_format', './modules/asistencias/templates//ClasesPorComponentes.tpl', 62, false),)), $this); ?>
<?php if (empty ( $this->_tpl_vars['cursoxcomponente'] )): ?>
	<p>No hay Inasistencias Reportadas</p>
<?php else: ?>
<!--
    <?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Listado de Inasistencias'), $this);?>

	<div class='ajax-response' id='ajax-listadoDeInasistencias'></div>
-->
<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Cursos Componente <?php echo ((is_array($_tmp=$this->_tpl_vars['nombreComponente']['nombrecomponente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
 
  <table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
<thead>
	<tr>
	<th  rowspan='3'>CURSOS</th>
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
		<?php $_from = $this->_tpl_vars['cursoxcomponente']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cursoxcomponente']):
?>
      <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cursoxcomponente']['curso'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['excusamedica'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['calamidad'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['estudio'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['transportemas'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
       
      <td class='total total-asistenciasJustificadas'></td>
       
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['nojustificada'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['trabajo'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['transportemenos'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
 </td>
        
   <td class='total total-asistenciasInjustificadas'></td>
  
       <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['cursoxcomponente']['total'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
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
