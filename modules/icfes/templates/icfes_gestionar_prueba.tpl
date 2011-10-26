<h3><?php echo (isset($_prueba))?"Actualización de Prueba<br/>{$_prueba['nombre']}" : 'Creación de Nueva Prueba'?></h3>
<fieldset id='form-edit-icfes-test' style='border: none; width: 8cm; margin: 0 auto'>
	<div>
		<div><label class='required'>Nombre</label><input type='text' name='prueba[nombre]' id='prueba_nombre' value='<?php echo $_prueba['nombre']?>'/></div><div class='clear'></div>
		<div><label class='required'>Fecha</label><input type = 'date' readonly='readonly' id='prueba_fecha' name='prueba[fecha]' value='<?php echo $_prueba['fecha']?>'/></div><div class='clear'></div>
		<div><label class='required'>Tipo</label><?php echo html_select_tag_by_array('prueba[tipo_icfes]', array('SIMULACRO','PRUEBA OFICIAL'), array('id'=>'prueba_tipo'), $_prueba['tipo_icfes'])?></div><div class='clear'></div>
		<div><label class='required'>Plan</label><?php echo html_select_tag_by_query('prueba[cod_programa]', QUERY_SELECT_TALENTOS, null, $_prueba['cod_programa'])?></div>
		<?php if(isset($cod_prueba)):?>
			<div style='margin:3mm'><a href='#' id='editarPreguntas'>Editar Preguntas</a></div><div class='clear'></div>
		<?php else:?>
			<div class='clear'></div>
		<?php endif;?>
		<div class='button-bar'>
			<button class='flat' style='width:2.2cm' id='submit'><?php echo (isset($_prueba))? 'Actualizar':'Crear'?></button>
			<button class='flat cancel'>Cancelar</button>
			<?php if(isset($cod_prueba)):?>
				<input type='hidden' name='cod_prueba' value='<?php echo $cod_prueba?>'/>
			<?php endif;?>
			<input type='hidden' name='action' value='<?php echo (isset($_prueba))?'actualizarPrueba':'crearPrueba'?>'/>
		</div>
	</div>
</fieldset>
<script>
	$('label.required').append('&nbsp;<strong style="font-size:8pt">*</strong>&nbsp;');
	$("input[type=date]").datepicker({dateFormat:'yy-mm-dd', changeMonth: true,	changeYear: true});
	$("fieldset button#submit").click(function(){
			if($F("input#prueba_nombre")=='')
				jAlert("DEBE INGRESAR UN NOMBRE PARA LA PRUEBA",'CAMPO VACÍO');
			else if($F("input#prueba_fecha")=='')
				jAlert("DEBE INGRESAR UNA FECHA PARA LA PRUEBA",'CAMPO VACÍO');
			else
					$.post("../src/icfesGestionarPruebas.php",$("fieldset#form-edit-icfes-test input, fieldset#form-edit-icfes-test select").serialize(),
							function(html){$("fieldset").append(html)	})
		})

	$("button#submit").click(function(){$("div#form-editar-preguntas, div#procesando-editar-preguntas").html("").hide('fast')})

	$("a#editarPreguntas").click(function(){
			$("div#form-editar-preguntas").html("").slideUp('fast');
			$("div#procesando-editar-preguntas").show().ajax_img();
			$.post("../src/icfesGestionarPruebas.php", {cod_prueba: "<?php echo $cod_prueba?>", action:'editarPreguntas'}, function(html){
				$("fieldset div.button-bar button").disable()
				$("div#procesando-editar-preguntas").html("").hide('fast');
				$("div#form-editar-preguntas").html(html).slideDown('medium')
				})
			return false;
		})
	$("fieldset button.cancel").click(function(){location.reload()})
</script>
