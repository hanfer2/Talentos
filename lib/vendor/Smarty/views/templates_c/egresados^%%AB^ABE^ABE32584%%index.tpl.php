<?php /* Smarty version 2.6.26, created on 2011-07-05 20:38:29
         compiled from modules/egresados/templates/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/egresados/templates/index.tpl', 10, false),array('function', 'nombre_programa', 'modules/egresados/templates/index.tpl', 13, false),array('function', 'persona_url', 'modules/egresados/templates/index.tpl', 36, false),array('function', 'link_to', 'modules/egresados/templates/index.tpl', 40, false),array('function', 'join', 'modules/egresados/templates/index.tpl', 46, false),array('modifier', 'escape', 'modules/egresados/templates/index.tpl', 39, false),)), $this); ?>
<div class="ui-widget decorated" id='ajax-listadoEgresados'>
  <?php $this->assign('ASPIRANTES_IES_TEXT', 'Aspirantes a Ingreso a Educaci&oacute;n Superior'); ?>
  <?php if (( empty ( $this->_tpl_vars['egresados'] ) )): ?>
		<?php ob_start(); ?>
		<p>No se hallaron <strong>Participantes Egresados 
			<?php if ($this->_tpl_vars['noIES']): ?> <?php echo $this->_tpl_vars['ASPIRANTES_IES_TEXT']; ?>
<?php endif; ?></strong>
			Registrados pertenecientes al PNAT <?php echo $this->_tpl_vars['cod_programa']; ?>

		</p>
		<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('err_message', ob_get_contents());ob_end_clean(); ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => $this->_tpl_vars['err_message']), $this);?>

  <?php else: ?>
  <h1>Listado de Estudiantes Egresados <?php if ($this->_tpl_vars['noIES']): ?> <br/><?php echo $this->_tpl_vars['ASPIRANTES_IES_TEXT']; ?>
<?php endif; ?></h1>
  <h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
  <table class="table dataTable" id="table-ListadoIES">
    <thead>
      <tr>
      	<th>C&oacute;digo</th>
        <th>Doc. Id</th>
        <th>Nombre</th>
        <th>Direcci&oacute;n</th>
        <th>Tel&eacute;fonos</th>
        <th title='Correo Electr&oacute;nico'>Correo E.</th>
        <th class='column-select-filter'>G&eacute;nero</th>
        <th>Edad<br/><div style="font-size:8pt">(A&ntilde;os)</div></th>
				<th class='column-select-filter long-select' >Colegio</th>
        <?php if (! $this->_tpl_vars['noIES']): ?>
        <th class='column-select-filter'>Ingreso<br/>Educ.Sup.</th>
        <th class='column-select-filter'>Laborando</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php $_from = $this->_tpl_vars['egresados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['egresado']):
?>
      <tr>
      	<td><?php echo $this->_tpl_vars['egresado']['cod_estud']; ?>
</td>
        <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</td>
        <td>
					<?php if (is_blank ( $this->_tpl_vars['egresado']['cod_universidad'] )): ?>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

						<div><?php echo smarty_function_link_to(array('name' => 'Registrar','action' => 'add','cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</div>
          <?php else: ?>
						<?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['fullname'],'action' => 'view','cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>

          <?php endif; ?>
        </td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['direccion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['egresado']['telefono']).";".($this->_tpl_vars['egresado']['tel_celular']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>
        <td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['egresado']['email']).";".($this->_tpl_vars['egresado']['email_2']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['genero'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['edad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['nombre_colegio'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<?php if (! $this->_tpl_vars['noIES']): ?>
        <td><?php if (is_blank ( $this->_tpl_vars['egresado']['cod_universidad'] )): ?> &#10008; <?php else: ?> &#10003; <?php endif; ?></td>
        <td><?php if (is_blank ( $this->_tpl_vars['egresado']['ocupacion'] )): ?> &#10008; <?php else: ?> &#10003; <?php endif; ?></td>
        <?php endif; ?>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
  <?php endif; ?>
  <div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Registrar Egresados','view' => 'add','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

  </div>
</div>

