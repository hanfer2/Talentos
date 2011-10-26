<?php /* Smarty version 2.6.26, created on 2011-07-06 16:55:57
         compiled from ./modules/estudiantes_movimientos/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/estudiantes_movimientos/templates//index.tpl', 18, false),array('function', 'math', './modules/estudiantes_movimientos/templates//index.tpl', 21, false),array('modifier', 'date_format', './modules/estudiantes_movimientos/templates//index.tpl', 18, false),)), $this); ?>
<div class="ui-widget decorated">
  <h1>Reporte de Ingresos/Bajas de Participantes</h1>
  <h2><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2>
  
  <table class="table" style="width:250px">
    <thead>
      <tr>
        <th class="ui-state-default">Fecha</th>
        <th class="ui-state-default">Ingresos</th>
        <th class="ui-state-default">Bajas</th>
        <th class="ui-state-default">Total</th>
      </tr>
    </thead>
    <tbody>
  
  <?php $_from = $this->_tpl_vars['mov']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dia']):
?>
    <tr>
      <td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['dia']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)),'action' => 'view','fecha' => $this->_tpl_vars['dia']['fecha']), $this);?>
</td>
      <td><?php echo $this->_tpl_vars['dia']['ingresos']; ?>
</td>
      <td><?php echo $this->_tpl_vars['dia']['bajas']; ?>
</td>
      <?php echo smarty_function_math(array('equation' => "t+i-b",'i' => $this->_tpl_vars['dia']['ingresos'],'b' => $this->_tpl_vars['dia']['bajas'],'t' => $this->_tpl_vars['total'],'assign' => 'total'), $this);?>

      <td><?php echo $this->_tpl_vars['total']; ?>
</td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
  </tbody>
  </table>
  <div class="date-report"><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
</div>