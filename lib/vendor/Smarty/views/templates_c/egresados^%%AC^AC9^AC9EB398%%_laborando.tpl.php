<?php /* Smarty version 2.6.26, created on 2011-09-18 20:58:52
         compiled from modules/egresados/templates/_laborando.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/egresados/templates/_laborando.tpl', 3, false),array('function', 'nombre_programa', 'modules/egresados/templates/_laborando.tpl', 6, false),array('function', 'persona_url', 'modules/egresados/templates/_laborando.tpl', 14, false),array('function', 'link_to', 'modules/egresados/templates/_laborando.tpl', 15, false),)), $this); ?>
<div class="ui-widget decorated">
	<?php if (empty ( $this->_tpl_vars['egresados'] )): ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => "No se hallaron reportados participantes egresados laborando pertenecientes al PNAT ".($this->_tpl_vars['cod_programa']),'title' => 'Listado de Egresados Laborando'), $this);?>

  <?php else: ?>
  <h1>Listado de Egresados Laborando</h1>
  <h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
  <table class="table dataTable" id="table-listadoEgresadosLaborando">
    <thead>
      <tr><th>Doc Id</th><th>Nombre</th><th>Ocupaci&oacute;n</th></tr>
    </thead>
    <tbody>
			<?php $_from = $this->_tpl_vars['egresados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['egresado']):
?>
      <tr>
        <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</td>
				<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['fullname'],'action' => 'view','cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</td>
				<td><?php echo $this->_tpl_vars['egresado']['ocupacion']; ?>
</td>
      </tr>
       <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>