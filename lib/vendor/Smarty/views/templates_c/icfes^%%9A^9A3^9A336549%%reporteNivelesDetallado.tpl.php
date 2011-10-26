<?php /* Smarty version 2.6.26, created on 2011-09-06 14:29:32
         compiled from modules/icfes/templates/reporteNivelesDetallado.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 30, false),array('modifier', 'upper', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 34, false),array('modifier', 'truncate', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 34, false),array('modifier', 'string_format', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 71, false),array('function', 'link_to', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 42, false),array('function', 'math', 'modules/icfes/templates/reporteNivelesDetallado.tpl', 52, false),)), $this); ?>
<div class='ui-widget decorated'>
  <h1>Reporte Detallado por Cursos por Niveles</h1>
  <h3><?php echo $this->_tpl_vars['nombre_prueba']; ?>
 - <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h3>
  
    <table class='table' id="table-icfes-reporteDetalladoPorNiveles">
    <thead>
      <tr>
        <th rowspan='2'>Curso</th>
        <th rowspan='2'>Nivel</th>
        <th rowspan='2'>Subnivel</th>
        <th colspan='<?php echo count($this->_tpl_vars['_componentes']); ?>
'>Componentes</th>
      </tr>
      <tr>
      	<?php $_from = $this->_tpl_vars['_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
        <th><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
</th>
        <?php endforeach; endif; unset($_from); ?>
      </tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['icfes_niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['codigo_curso'] => $this->_tpl_vars['superniveles']):
?>
      <tr>
        <th rowspan='<?php echo count($this->_tpl_vars['_niveles']); ?>
'>
        	<?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['superniveles']['nombre_curso'],'action' => 'view','cod_curso' => $this->_tpl_vars['codigo_curso'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>

        </th>

				<?php $_from = $this->_tpl_vars['superniveles']['niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['supernivel'] => $this->_tpl_vars['niveles']):
?>
        	<th rowspan='<?php echo count($this->_tpl_vars['niveles']); ?>
'> <?php echo $this->_tpl_vars['supernivel']; ?>
</th>
        	<?php $_from = $this->_tpl_vars['niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nivel'] => $this->_tpl_vars['componentes']):
?>
        		<th style='text-align: left'><?php echo $this->_tpl_vars['nivel']; ?>
</th>
        		<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente'] => $this->_tpl_vars['registro']):
?>
      			  <td title="Cantidad Estudiantes de <?php echo $this->_tpl_vars['superniveles']['nombre_curso']; ?>
 para <?php echo $this->_tpl_vars['componente']; ?>
 en Nivel <?php echo $this->_tpl_vars['nivel']; ?>
 = <?php echo $this->_tpl_vars['registro']; ?>
">
                <div class='porcentaje'>
                	<?php echo smarty_function_math(array('equation' => "100 *  registro / cantidad",'registro' => $this->_tpl_vars['registro'],'cantidad' => $this->_tpl_vars['clasificador']->cant_estud[$this->_tpl_vars['cod_curso']][$this->_tpl_vars['componente']],'format' => "%.2f%%"), $this);?>

                </div>
                <div class='ratio'><?php echo ($this->_tpl_vars['registro'])." / ".($this->_tpl_vars['clasificador']->cant_estud[$this->_tpl_vars['cod_curso']][$this->_tpl_vars['componente']]); ?>
</div>
        			</td>
             <?php endforeach; endif; unset($_from); ?>
      			</tr>
          <?php endforeach; endif; unset($_from); ?>
        <?php endforeach; endif; unset($_from); ?>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table><br/>
  <!-- Convenciones -->
  <table id='table-icfes-convencionesNiveles' class="table table-convenciones">
    <caption>CONVENCIONES</caption>
    <thead>
      <tr><th>Subnivel</th><th>Rango</th></tr>
    </thead>
    <tbody>
    	<?php $_from = $this->_tpl_vars['_niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['nivel']):
?>
          <tr><td><?php echo $this->_tpl_vars['nivel']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['rangos'][$this->_tpl_vars['id']][0])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['rangos'][$this->_tpl_vars['id']][1])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td></tr>
			<?php endforeach; endif; unset($_from); ?>
  </table>
</div>