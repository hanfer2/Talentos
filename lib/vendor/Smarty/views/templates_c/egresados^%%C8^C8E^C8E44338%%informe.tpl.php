<?php /* Smarty version 2.6.26, created on 2011-08-16 14:32:08
         compiled from modules/egresados/templates/informe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/egresados/templates/informe.tpl', 2, false),array('function', 'nombre_programa', 'modules/egresados/templates/informe.tpl', 7, false),array('function', 'count', 'modules/egresados/templates/informe.tpl', 20, false),array('function', 'link_to', 'modules/egresados/templates/informe.tpl', 22, false),array('function', 'pluralize', 'modules/egresados/templates/informe.tpl', 36, false),array('modifier', 'date_format', 'modules/egresados/templates/informe.tpl', 8, false),array('modifier', 'escape', 'modules/egresados/templates/informe.tpl', 35, false),)), $this); ?>
<?php if (is_blank ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Informe de Egresados','extra' => 'TRUE'), $this);?>

	<div class='ajax-response' id="ajax-informe-egresados"></div>
<?php else: ?>
	<div class='ui-widget decorated ui-informe-panel'>
		<h1>Informe de Egresados<br/>	con Ingreso a Educaci&oacute;n Superior</h1>
		<h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
		<h3><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</h3>
    <?php if (isset ( $this->_tpl_vars['informe'] ) && $this->_tpl_vars['informe'] == FALSE): ?>
      <p><span class='ui-icon ui-icon-alert error-icon inline-icon'></span> No hay estudiantes reportados como egresados para este <?php echo $this->_config[0]['vars']['PNAT']; ?>
</p>
    <?php else: ?>
      <div class="ui-toolbar non-printable">
        <a href="#" id="link-collapseAll">Informe Resumido</a> | 
        <a href="#" id="link-expandAll">Informe Detallado</a>
      </div>
      <?php $_from = $this->_tpl_vars['universidades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_universidad'] => $this->_tpl_vars['universidad']):
?>
      <table class='component-report'>
      <tbody>
        <tr>
        <?php echo smarty_function_count(array('var' => $this->_tpl_vars['carreras'][$this->_tpl_vars['cod_universidad']],'assign' => 'cant_univ'), $this);?>

          <td class='name-component-report' rowspan="<?php echo $this->_tpl_vars['cant_univ']; ?>
">
          <?php echo $this->_tpl_vars['cod_universidad']; ?>
 - <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['universidad']['nombre'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['cod_universidad']), $this);?>

          </td>
          <?php $_from = $this->_tpl_vars['carreras'][$this->_tpl_vars['cod_universidad']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_carrera'] => $this->_tpl_vars['carrera']):
?>
            <td class='informe-nombre-carreras'>
            <?php echo $this->_tpl_vars['cod_carrera']; ?>
 - <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['carrera']['nombre'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['cod_universidad'],'cod_carrera' => $this->_tpl_vars['cod_carrera']), $this);?>

            </td>
            <th class='informe-cant-egresados'><?php echo $this->_tpl_vars['carrera']['counter']; ?>
</th>
        </tr>
          <?php endforeach; endif; unset($_from); ?>
      </tbody>
      <tfoot class='clickable'>
        <tr>
          <td colspan="2" class='name-component-report' >
            <span><?php echo ((is_array($_tmp=$this->_tpl_vars['universidad']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>
            <span> - <?php echo smarty_function_pluralize(array('count' => $this->_tpl_vars['cant_univ'],'singular' => 'Carrera','plural' => 'Carreras'), $this);?>
</span>
          </td>
          <th class='informe-cant-egresados'><?php echo $this->_tpl_vars['universidad']['counter']; ?>
</th>
        </tr>
      </tfoot>
      </table>
      <?php endforeach; endif; unset($_from); ?>

      <table class='summary-report'>
      <tbody>
        <tr>
          <td class='total-label-sumary-report'>
            Total Estudiantes<br/>con Ingreso a la Educaci&oacute;n Superior
          </td>
          <th class='total-sumary-report'style=" "><?php echo $this->_tpl_vars['totalIES']; ?>
</th>
        </tr>
      </tbody>
      </table>
      
      <div class="date-report"> Generado: <span class="date"><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>
</span></div>
    <?php endif; ?>
	</div>
<?php endif; ?>