<?php /* Smarty version 2.6.26, created on 2011-11-02 15:20:27
         compiled from ./modules/icfes/templates//comparativas.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/icfes/templates//comparativas.tpl', 2, false),array('modifier', 'escape', './modules/icfes/templates//comparativas.tpl', 24, false),array('modifier', 'date_format', './modules/icfes/templates//comparativas.tpl', 33, false),array('modifier', 'lower', './modules/icfes/templates//comparativas.tpl', 42, false),array('modifier', 'capitalize', './modules/icfes/templates//comparativas.tpl', 42, false),array('modifier', 'string_format', './modules/icfes/templates//comparativas.tpl', 47, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Reporte de Comparativas Icfes'), $this);?>

	<div class='ajax-request'></div>
<?php else: ?>
<div class='decorated ui-widget'>
	<h1>Reporte de Comparativas</h1>
	<h2><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2>
	<?php if ($this->_tpl_vars['tipos_icfes'] == null): ?>
		<div class='empty-message-error'>
			No hay a&uacute;n Pruebas Icfes/Simulacros Registrados para <?php echo $this->_tpl_vars['nombre_programa']; ?>

		</div>
	<?php else: ?>
  <div class="tabs" id="tabs-icfesComparativas">
    <ul>
      <li><a href="#tab-promediosGeneralesRelativo">Promedios Respecto a otra prueba</a></li>
      <li><a href="#tab-promediosGeneralesAbsoluto">Promedios Absolutos</a></li>
    </ul>

  

    <!-- PROMEDIOS GENERALES RELATIVOS -->
    <div id="tab-promediosGeneralesRelativo">
      <h3>Comparativa de Promedios Generales Icfes</h3>
      <h4>con respecto al N&deg; de Estudiantes de <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['ultimo_icfes']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</strong></h4>
      <table id='table-promediosRelativo' class='table dataTable dt-non-paginable table-icfesComparativas'>
        <thead>
          <tr>
            <th>COMPONENTES</th>
            <?php $_from = $this->_tpl_vars['tipos_icfes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['icfes']):
?>
							<?php $this->assign('cod_prueba', $this->_tpl_vars['icfes']['codigo']); ?>
            <th>
              <div class='nombrePrueba'><?php echo ((is_array($_tmp=$this->_tpl_vars['icfes']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
              <div class='subtitle-header'><?php echo ((is_array($_tmp=$this->_tpl_vars['icfes']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
							<div class='subtitle-header'>Participantes: <?php echo $this->_tpl_vars['promedios']['relative'][$this->_tpl_vars['cod_prueba']]['cantidad']; ?>
</div>
            </th>
            <?php endforeach; endif; unset($_from); ?>
          </tr>
        </thead>
        <tbody>
        <?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
          <tr>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
            <?php $_from = $this->_tpl_vars['tipos_icfes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['icfes']):
?>
							<?php $this->assign('cod_prueba', $this->_tpl_vars['icfes']['codigo']); ?>
							<?php $this->assign('componente_in_lower', ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp))); ?>
							<td>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['promedios']['relative'][$this->_tpl_vars['cod_prueba']][$this->_tpl_vars['componente_in_lower']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>

							</td>
            <?php endforeach; endif; unset($_from); ?>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
      <div id='chart-container-relativo' style='margin:0 auto; margin-top:8mm; width:20cm'></div>
    </div>
    
      <!-- PROMEDIOS GENERALES ABSOLUTOS -->
    <div id="tab-promediosGeneralesAbsoluto">

      <h3>Comparativa de Promedios Generales Icfes</h3>
      <table id='table-promediosAbsoluto' class='table dataTable dt-non-paginable table-icfesComparativas'>
        <thead>
          <tr>
            <th>COMPONENTES</th>
            <?php $_from = $this->_tpl_vars['tipos_icfes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['icfes']):
?>
							<?php $this->assign('cod_prueba', $this->_tpl_vars['icfes']['codigo']); ?>
							<th>
								<div class='nombrePrueba'><?php echo ((is_array($_tmp=$this->_tpl_vars['icfes']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
								<div class='subtitle-header'><?php echo ((is_array($_tmp=$this->_tpl_vars['icfes']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
								<div class='subtitle-header'>Participantes: <strong><?php echo $this->_tpl_vars['promedios']['absolute'][$this->_tpl_vars['cod_prueba']]['cantidad']; ?>
</strong></div>
							</th>
            <?php endforeach; endif; unset($_from); ?>
          </tr>
        </thead>
        <tbody>
					<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
          <tr>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
            <?php $_from = $this->_tpl_vars['tipos_icfes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['icfes']):
?>
							<?php $this->assign('cod_prueba', $this->_tpl_vars['icfes']['codigo']); ?>
							<?php $this->assign('componente_in_lower', ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp))); ?>
							<td>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['promedios']['absolute'][$this->_tpl_vars['cod_prueba']][$this->_tpl_vars['componente_in_lower']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>

							</td>
            <?php endforeach; endif; unset($_from); ?>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
      
      <div id='chart-container-absoluto' style='margin:0 auto; margin-top:8mm; width:20cm'></div>
    </div>
  </div>
  
  <?php endif; ?>
</div>
<?php endif; ?>