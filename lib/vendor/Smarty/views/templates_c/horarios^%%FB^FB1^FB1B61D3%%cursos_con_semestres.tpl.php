<?php /* Smarty version 2.6.26, created on 2011-07-06 16:42:31
         compiled from templates/_shared/cursos_con_semestres.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'camelize', 'templates/_shared/cursos_con_semestres.tpl', 3, false),array('modifier', 'range_assoc', 'templates/_shared/cursos_con_semestres.tpl', 17, false),array('function', 'to_sql', 'templates/_shared/cursos_con_semestres.tpl', 6, false),array('function', 'html_select', 'templates/_shared/cursos_con_semestres.tpl', 7, false),)), $this); ?>
<div class="ui-widget decorated non-printable">
  <h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
  <div class="ui-form form-select-curso" id="form-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">
    <div class="ui-field">
      <label for="cod_programa"><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_to_sql(array('classname' => 'TPrograma','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql']), $this);?>

    </div>
    <div class="ui-field">
      <label for="cod_curso">Curso</label>
			<?php echo smarty_function_to_sql(array('classname' => 'TSubgrupo','assign' => 'cursos_sql'), $this);?>

      <?php echo smarty_function_html_select(array('name' => 'cod_curso','options' => $this->_tpl_vars['cursos_sql'],'extra' => $this->_tpl_vars['extra'],'title' => 'Curso'), $this);?>

    </div>
    <div class="ui-field">
			<label for="semestre">Semestre</label>
			<?php if (! isset ( $this->_tpl_vars['semestres'] )): ?>
				<?php $this->assign('semestres', ((is_array($_tmp=1)) ? $this->_run_mod_handler('range_assoc', true, $_tmp, 2) : range_assoc($_tmp, 2))); ?>
			<?php endif; ?>
			<?php echo smarty_function_html_select(array('name' => 'semestre','options' => $this->_tpl_vars['semestres'],'selected' => 2), $this);?>

    </div>
    <div class="ui-button-bar">
      <button id="bt-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">Consultar</button>
    </div>
		<?php echo $this->_tpl_vars['links']; ?>

  </div>
</div>