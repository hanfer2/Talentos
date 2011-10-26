<?php /* Smarty version 2.6.26, created on 2011-07-06 16:43:50
         compiled from ./modules/auditoria/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'persona_url', './modules/auditoria/templates//view.tpl', 8, false),array('function', 'link_to', './modules/auditoria/templates//view.tpl', 37, false),array('function', 'include_partial', './modules/auditoria/templates//view.tpl', 54, false),array('modifier', 'date_format', './modules/auditoria/templates//view.tpl', 34, false),)), $this); ?>
<div class="ui-widget decorated">
  
  <?php if (! isset ( $this->_tpl_vars['all'] )): ?> 
  <h1>Listado Cambios de <?php echo $this->_tpl_vars['auditoria']; ?>
</h1>
  <h2><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2>
  <div>
    <?php if (isset ( $this->_tpl_vars['cedula'] )): ?>
    <h2><?php echo smarty_function_persona_url(array(), $this);?>
 - <?php echo $this->_tpl_vars['fullname']; ?>
</h2>
    <h3><?php echo $this->_tpl_vars['auditoria']; ?>
 Actual <span class='resaltar'> <?php echo $this->_tpl_vars['persona']; ?>
 </span></h3>
    <?php endif; ?>
    
    <?php if (empty ( $this->_tpl_vars['cambios'] )): ?>
    <div class="ui-state-error frm-4 ui-corner-all">
      <span class="ui-icon ui-icon-alert error-icon left-icon"></span>
      No se hallaron cambios de <?php echo $this->_tpl_vars['auditoria']; ?>

    </div>
    <?php else: ?>
      <table class="table dataTable">
        <thead>
          <tr>
            <th class="ui-state-default">Fecha</th>
            <?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
            <th class="ui-state-default">Doc. ID.</th>
            <th class="ui-state-default">Nombre</th>
            <?php endif; ?>  
            <th class="ui-state-default">Realizado por</th>
            <th class="ui-state-default">Estado Previo</th>
            <th class="ui-state-default">Estado Actual</th>
          </tr>
        </thead>
        <tbody>
          <?php $_from = $this->_tpl_vars['cambios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cambio']):
?>
          <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['cambio']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>
</td>
            <?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
            <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cambio']['cedula']), $this);?>
</td>
            <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['cambio']['fullname'],'action' => 'view_all','cedula' => $this->_tpl_vars['cambio']['cedula']), $this);?>
</td>
            <?php endif; ?>     
            
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

  <?php else: ?>
  <h1>Listado de Cambios</h1>
    <h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['fullname']; ?>
</h2>
    <div class="accdn ui-corner-all" id="accdn-reporte_cambios" style="width: 650px">
      <?php echo smarty_function_include_partial(array('file' => "_view.tpl",'nombre_campo' => 'Estado','auditable' => $this->_tpl_vars['estado'],'cambios' => $this->_tpl_vars['cambios_estado']), $this);?>

      <?php echo smarty_function_include_partial(array('file' => "_view.tpl",'nombre_campo' => "Doc. ID",'auditable' => $this->_tpl_vars['cedula'],'cambios' => $this->_tpl_vars['cambios_cedula']), $this);?>

      <?php echo smarty_function_include_partial(array('file' => "_view.tpl",'nombre_campo' => 'Rol','auditable' => $this->_tpl_vars['rol'],'cambios' => $this->_tpl_vars['cambios_rol']), $this);?>

    </div>
  <?php endif; ?>
  <div class="date-report">Generado: <strong class="date"><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>
</strong></div>
</div>
<style type="text/css">
  <?php echo '
  span.estado_actual { 
    color: red; 
    font-weight: bold;
  }
  '; ?>

 </style>
