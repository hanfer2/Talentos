<?php /* Smarty version 2.6.26, created on 2011-07-06 16:48:13
         compiled from modules/auditoria/templates/_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'modules/auditoria/templates/_view.tpl', 24, false),)), $this); ?>
<div class="accdn-item ui-corner-all">
  <h3 class="ui-state-default">Cambios de <?php echo $this->_tpl_vars['nombre_campo']; ?>
</h3>
  <div> <span class="ui-icon ui-icon-arrow-1-e inline-icon"></span><?php echo $this->_tpl_vars['nombre_campo']; ?>
 Actual <span class='estado_actual'><?php echo $this->_tpl_vars['auditable']; ?>
</span></div>
    <?php if (empty ( $this->_tpl_vars['cambios'] )): ?>
    <div>
      <p class="ui-state-highlight ui-corner-all notif-block msg-s4">
        <span class="ui-icon ui-icon-info inline-icon"></span> 
        Este estudiante NO reporta cambios de <strong><?php echo $this->_tpl_vars['nombre_campo']; ?>
</strong> hasta el momento.
      </p>
    </div>
    <?php else: ?>
    <table class="table dataTable">
      <thead>
        <tr>
          <th class="ui-state-default">Fecha</th>           
          <th class="ui-state-default">Realizado por</th>
          <th class="ui-state-default">Antes</th>
          <th class="ui-state-default">Después</th>
        </tr>
      </thead>
      <tbody>
        <?php $_from = $this->_tpl_vars['cambios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cambio']):
?>
        <tr>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cambio']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>
</td> 
          <td><?php echo $this->_tpl_vars['cambio']['realizado_por']; ?>
</td>
          <td><?php echo $this->_tpl_vars['cambio']['estado_previo']; ?>
</td>
          <td><?php echo $this->_tpl_vars['cambio']['estado_nuevo']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    <?php endif; ?>
</div>