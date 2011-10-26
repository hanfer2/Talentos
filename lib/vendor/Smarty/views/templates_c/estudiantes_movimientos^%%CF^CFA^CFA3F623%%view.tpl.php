<?php /* Smarty version 2.6.26, created on 2011-07-06 16:56:20
         compiled from ./modules/estudiantes_movimientos/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', './modules/estudiantes_movimientos/templates//view.tpl', 3, false),array('modifier', 'escape', './modules/estudiantes_movimientos/templates//view.tpl', 25, false),array('modifier', 'default', './modules/estudiantes_movimientos/templates//view.tpl', 27, false),array('function', 'link_to', './modules/estudiantes_movimientos/templates//view.tpl', 6, false),array('function', 'persona_url', './modules/estudiantes_movimientos/templates//view.tpl', 24, false),)), $this); ?>
<div class="ui-widget decorated">
  <h1>Reporte de Ingresos/Bajas</h1>
  <h2>Fecha <?php echo ((is_array($_tmp=$this->_tpl_vars['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</h2>
  
  <div class="ui-toolbar">
      <?php echo smarty_function_link_to(array('name' => "Listado de Ingresos/bajas"), $this);?>

  </div>
  
  <div class="toolbar fg-toolbar tb-main">
    <a href="#accdn-item-ingresos" class="fg-button ui-state-default ui-state-active ui-corner-left">Ingresos</a>
    <a href="#accdn-item-bajas" class="fg-button ui-state-default ui-state-default ui-corner-right">Bajas</a>
  </div>
  
  <div style="width: 600px" id="accdn-reporte" class="accdn">
    <div class="accdn-item ui-corner-all" id="accdn-item-ingresos">
    <h3 class="ui-state-default ui-corner-all">Ingresos</h3>
    <table class="dataTable table" id="table-ingresos">
      <thead>
        <tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th><th>Realizado Por</th></tr>
      </thead>
      <tbody>
        <?php $_from = $this->_tpl_vars['ingresos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ingreso']):
?>
        <tr>
          <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['ingreso']['cedula']), $this);?>
</td>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['ingreso']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <td><?php echo $this->_tpl_vars['ingreso']['nombre_grupo']; ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['ingreso']['creado_por'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Sistema') : smarty_modifier_default($_tmp, 'Sistema')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    </div>
    
    <div class="accdn-item ui-corner-all ui-helper-hidden" id="accdn-item-bajas">
    <h3 class="ui-state-default ui-corner-all">Bajas</h3>
    <table class="dataTable table" id="table-bajas">
      <thead>
        <tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th><th>Realizado Por</th></tr>
      </thead>
      <tbody>
        <?php $_from = $this->_tpl_vars['bloqueados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bloqueado']):
?>
        <tr>
          <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['bloqueado']['cedula']), $this);?>
</td>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['bloqueado']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <td><?php echo $this->_tpl_vars['bloqueado']['nombre_grupo']; ?>
</td>
          <td><?php echo $this->_tpl_vars['bloqueado']['creado_por']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    </div>
  </div>
  
  <script type="text/javascript">
    <?php echo '
    $(function(){
      $("a",".tb-main").click(function(){
        var target = this.hash;
        var jqTarget = $(target);
        var _this = $(this);
        
       
        
        jqTarget.slideToggle();
        _this.toggleClass("ui-state-active");
        return false;
      });
    })
    
    '; ?>

  </script>
</div>
