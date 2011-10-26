<?php /* Smarty version 2.6.26, created on 2011-07-06 16:41:08
         compiled from ./modules/docentes/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/docentes/templates//index.tpl', 6, false),array('function', 'link_to', './modules/docentes/templates//index.tpl', 9, false),array('function', 'persona_url', './modules/docentes/templates//index.tpl', 31, false),array('modifier', 'escape', './modules/docentes/templates//index.tpl', 32, false),array('modifier', 'lower', './modules/docentes/templates//index.tpl', 37, false),array('modifier', 'date_format', './modules/docentes/templates//index.tpl', 39, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['cod_programa'] )): ?>
  <div class="ui-widget decorated">
    <h1>Listado de Docentes</h1>
    <?php if ($this->_tpl_vars['cod_programa'] != '0'): ?><h2><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2><?php endif; ?>
    <?php if (( empty ( $this->_tpl_vars['docentes'] ) )): ?>
      <?php echo smarty_function_include_template(array('file' => 'message_empty_results'), $this);?>

    <?php else: ?>
      <div class="ui-toolbar">
        <?php echo smarty_function_link_to(array('name' => 'Listado de Docentes Por Cursos','controller' => 'docentes','action' => 'cursos'), $this);?>
 |
        <?php echo smarty_function_link_to(array('name' => 'Informe de Docentes','controller' => 'docentes','action' => 'informe'), $this);?>

      </div>
      <table class="table dataTable">
        <thead>
          <tr>
            <?php if (is_super_admin_login ( )): ?>
            <th>Cód</th>
            <?php endif; ?>
            <th>C&eacute;dula</th><th>Nombre</th>
            <th class='column-select-filter'>G&eacute;nero</th><th>Tel&eacute;fono</th>
            <th>Celular</th><th>Direcci&oacute;n</th><th>E-mail</th>
            <th class='column-select-filter'>Ciudad</th>
            <th class='column-select-filter date'>Fecha Ingreso</th>
          </tr>
        </thead>
        <tbody>
          <?php $_from = $this->_tpl_vars['docentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['docente']):
?>
          <tr>
            <?php if (is_super_admin_login ( )): ?>
            <td><?php echo $this->_tpl_vars['docente']['cod_interno']; ?>
</td>
            <?php endif; ?>
            <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['docente']['cedula']), $this);?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['genero'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['telefono'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['tel_celular'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['direccion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['docente']['email'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['ciudad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['fecha_ingreso'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
<?php else: ?>
  <?php echo smarty_function_include_template(array('file' => "programa.form",'title' => 'Listado de Docentes','extra' => 'TODOS'), $this);?>

  <div id='ajax-listadoDeDocentes'></div>
<?php endif; ?>
