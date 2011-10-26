<?php /* Smarty version 2.6.26, created on 2011-08-16 14:34:22
         compiled from ./modules/universidades/templates//egresados.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/universidades/templates//egresados.tpl', 3, false),array('function', 'include_template', './modules/universidades/templates//egresados.tpl', 8, false),array('function', 'info', './modules/universidades/templates//egresados.tpl', 13, false),array('function', 'persona_url', './modules/universidades/templates//egresados.tpl', 33, false),)), $this); ?>
	<div class="ui-widget decorated">
	<?php ob_start(); ?>
			<?php echo smarty_function_link_to(array('name' => 'Listado Total de Egresados','controller' => 'egresados'), $this);?>
 | 
			<?php echo smarty_function_link_to(array('name' => 'Listado de Universidades'), $this);?>
 | 
			<?php echo smarty_function_link_to(array('name' => 'Registrar Egresado','controller' => 'egresados','action' => 'add'), $this);?>

	<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('links', ob_get_contents());ob_end_clean(); ?>
	<?php if (empty ( $this->_tpl_vars['egresados'] )): ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => 'No se hallaron egresados en esta Universidad','links' => $this->_tpl_vars['links']), $this);?>

	<?php else: ?>

		<h1>Listado de Egresados </h1>
		<h2><?php echo $this->_tpl_vars['cod_universidad']; ?>
 - <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['nombre_universidad'],'action' => 'carreras','cod_universidad' => $this->_tpl_vars['cod_universidad'],'cod_ciudad' => $this->_tpl_vars['cod_ciudad']), $this);?>
</h2>
		<h3><?php if (! is_blank ( $this->_tpl_vars['cod_carrera'] )): ?> <?php echo smarty_function_info(array('classname' => 'TCarrera','func' => 'nombre','args' => $this->_tpl_vars['cod_carrera']), $this);?>
 <?php endif; ?></h2>
		<table class="table dataTable" id="table-egresadosIES">
			<thead>
				<tr>
					<th>Doc. Id.</th>
					<th>Nombre</th>
					<th>Plan</th>
					<?php if (! isset ( $this->_tpl_vars['cod_universidad'] )): ?>
					<th class='column-select-filter long-select'>Inst. Educ. Sup.</th>
					<?php elseif (! isset ( $this->_tpl_vars['cod_carrera'] )): ?>
					<th class='column-select-filter long-select'>Carrera</th>
					<?php endif; ?>
					<?php if (! isset ( $this->_tpl_vars['cod_universidad'] )): ?>
					<th class='column-select-filter'>Ciudad</th>
					<?php endif; ?>
				</tr>
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
					<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['cod_programa'],'cod_programa' => $this->_tpl_vars['egresado']['cod_programa'],'tipo' => 'IES'), $this);?>
</td>
					<?php if (! isset ( $this->_tpl_vars['cod_universidad'] )): ?>
					<td><?php echo $this->_tpl_vars['egresado']['nombre_universidad']; ?>
</td>
					<?php elseif (! isset ( $this->_tpl_vars['cod_carrera'] )): ?>
					<td><?php echo $this->_tpl_vars['egresado']['nombre_carrera']; ?>
</td>     
					<?php endif; ?>
					<?php if (! isset ( $this->_tpl_vars['cod_universidad'] )): ?>
					<td><?php echo $this->_tpl_vars['egresado']['nombre_ciudad']; ?>
</td>     
					<?php endif; ?>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
		<div class="ui-toolbar">
			<?php echo $this->_tpl_vars['links']; ?>

		</div>
	</div>
<?php endif; ?>