<?php /* Smarty version 2.6.26, created on 2011-11-11 15:14:12
         compiled from modules/i_cuestionarios/templates/add.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'modules/i_cuestionarios/templates/add.form.tpl', 5, false),array('modifier', 'zeropad', 'modules/i_cuestionarios/templates/add.form.tpl', 5, false),array('modifier', 'explode', 'modules/i_cuestionarios/templates/add.form.tpl', 21, false),array('function', 'html_select', 'modules/i_cuestionarios/templates/add.form.tpl', 9, false),)), $this); ?>
<div class='questions-line-field ui-form-inline <?php if ($this->_tpl_vars['pregunta']['valida'] != 't'): ?>ui-state-disabled<?php endif; ?>'>
	<div class='ui-field cabecera-pregunta'>
    
		<label>Pregunta:</label>
		<input name="preguntas[<?php echo $this->_tpl_vars['flag']; ?>
][numeral]" class="pregunta-numeral" value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['pregunta']['numeral'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)))) ? $this->_run_mod_handler('zeropad', true, $_tmp, 3) : zeropad($_tmp, 3)); ?>
" maxlength="3" size="10" id="numeral"/>
         <!---->
	</div> 
	<div class='ui-field'><label>Área:</label>
		<?php echo smarty_function_html_select(array('name' => "preguntas[".($this->_tpl_vars['flag'])."][cod_componente]",'options' => $this->_tpl_vars['componentes'],'class' => "pregunta-componente",'selected' => ((is_array($_tmp=@$this->_tpl_vars['pregunta']['cod_componente'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

	</div>
	<div class='ui-field'><label>Componente:</label>
		<?php echo smarty_function_html_select(array('name' => "preguntas[".($this->_tpl_vars['flag'])."][cod_cualitativo]",'options' => $this->_tpl_vars['cualitativos'],'class' => "pregunta-cualitativo",'selected' => $this->_tpl_vars['pregunta']['cod_cualitativo']), $this);?>

	</div>
	
	<div class='ui-field'><label>Competencia:</label>
		<?php echo smarty_function_html_select(array('name' => "preguntas[".($this->_tpl_vars['flag'])."][cod_competencia]",'options' => $this->_tpl_vars['competencias'],'class' => "pregunta-competencia",'selected' => $this->_tpl_vars['pregunta']['cod_competencia']), $this);?>

	</div>
	<div class='ui-field inline'>
	<label class='label-title'>Respuesta Correcta:</label>
	<?php $_from = $this->_tpl_vars['respuestas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['letra']):
?>
		<?php $this->assign('respuestasCorrectas', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, ($this->_tpl_vars['pregunta']['respuesta'])) : explode($_tmp, ($this->_tpl_vars['pregunta']['respuesta'])))); ?>
		<span><?php echo $this->_tpl_vars['letra']; ?>
 <input type='checkbox' name='preguntas[<?php echo $this->_tpl_vars['flag']; ?>
][respuesta][]' value="<?php echo $this->_tpl_vars['letra']; ?>
" class="pregunta-respuesta" <?php if (in_array ( $this->_tpl_vars['letra'] , $this->_tpl_vars['respuestasCorrectas'] )): ?>checked="checked"<?php endif; ?>/></span>
	<?php endforeach; endif; unset($_from); ?>
	</div>
	<div class='ui-field'>
	<label>V&aacute;lida</label>
	<input type='checkbox' name='preguntas[<?php echo $this->_tpl_vars['flag']; ?>
][valida]' <?php if ($this->_tpl_vars['pregunta']['valida'] != 'f'): ?>checked="checked<?php endif; ?>" value="t" class="pregunta-valida"/>
	</div>
	<?php if (! $this->_tpl_vars['estaCalificada']): ?>
	<div class="inline"> <a href="#" class='link-removerPregunta' title="Eliminar Pregunta"><span class='ui-icon ui-icon-close ui-icon-error inline-icon'></span></a></div>
	<?php endif; ?>
	<input  name="preguntas[<?php echo $this->_tpl_vars['flag']; ?>
][codigo]" value="<?php echo $this->_tpl_vars['pregunta']['codigo']; ?>
" class="pregunta-codigo" id="codigoo"/>
</div>
<?php echo '
 <script>

  $("input[id=\'numeral\']").change(function () {
   // alert("aqui");
      var id = $(this).attr(\'name\'); 
   
    var total= id.substring(0,12)+"[codigo]";

  var codigo= $("input[name=\'"+total+"\']").val();
  var caracter = codigo.indexOf("-");
  caracter = codigo.substring(0,caracter+1)
    $("input[name=\'"+total+"\']").val(caracter+$("input[name=\'"+id+"\']").val());
})

</script>
'; ?>

