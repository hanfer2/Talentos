<?php /* Smarty version 2.6.26, created on 2011-11-16 14:31:43
         compiled from modules/cursos/templates/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/cursos/templates/index.tpl', 2, false),array('function', 'link_open_external', 'modules/cursos/templates/index.tpl', 6, false),array('function', 'nombre_programa', 'modules/cursos/templates/index.tpl', 8, false),array('function', 'link_to', 'modules/cursos/templates/index.tpl', 27, false),array('modifier', 'escape', 'modules/cursos/templates/index.tpl', 25, false),array('modifier', 'zeropad', 'modules/cursos/templates/index.tpl', 28, false),array('modifier', 'default', 'modules/cursos/templates/index.tpl', 31, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Listado de Cursos'), $this);?>

	<div class='ajax-response'></div>
<?php elseif (! empty ( $this->_tpl_vars['cursos'] )): ?>
<div class="ui-widget decorated">
	<?php echo smarty_function_link_open_external(array(), $this);?>

  <h1>Listado de Cursos</h1>
  <h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
  <table class="table dataTable dt-non-paginable" id="table-listadoCursos">
    <thead>
      <tr>
        <?php if (is_root_login ( )): ?>
				<th>C&oacute;digo</th>
        <?php endif; ?>
				<th class='column-select-filter'>Grupo</th><th>Curso</th>
        <th>Cupos</th>
				<th title='N&uacute;mero de Estudiantes Activos inscritos en el Curso'>N&deg;<br/>Estud.</th>
				<th class='column-select-filter'>Tipo</th>
			</tr>
    </thead>
    <tbody>
			<?php $_from = $this->_tpl_vars['cursos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curso']):
?>
        <tr>
          <?php if (is_root_login ( )): ?>
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['curso']['codigo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <?php endif; ?>
          <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['curso']['grupo'],'action' => 'index','cod_grupo' => $this->_tpl_vars['curso']['grupo'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</td>
          <td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['curso']['subgrupo'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 2) : zeropad($_tmp, 2)),'action' => 'view','cod_curso' => $this->_tpl_vars['curso']['codigo']), $this);?>
</td>
          <td><?php echo $this->_tpl_vars['curso']['cupos']; ?>
</td>
          <td><?php echo $this->_tpl_vars['curso']['cantidad_estudiantes']; ?>
</td>
					<td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['curso']['tipo'])) ? $this->_run_mod_handler('default', true, $_tmp, "Académico") : smarty_modifier_default($_tmp, "Académico")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
  <div class="ui-toolbar">
    <a href="#<?php if (isset ( $this->_tpl_vars['cod_grupo'] )): ?><?php echo $this->_tpl_vars['cod_grupo']; ?>
<?php endif; ?>" id="link-verNotificaciones">Ver Notificaciones -<?php if (isset ( $this->_tpl_vars['cod_grupo'] )): ?> Grupo <?php echo $this->_tpl_vars['cod_grupo']; ?>
<?php else: ?>Globales<?php endif; ?></a>
  </div>
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
</div>
<?php else: ?>
	<div class="ui-widget decorated">
	<h1>No se hallaron registros</h1>
	<p>No se hallaron cursos</p>
	</div>
<?php endif; ?>