<h3>Definición de Preguntas</h3>
<?php if(is_null($_preguntas)):?>

<?php else:?>
	<?php foreach($_preguntas as $idx=>$pregunta):?>
		<?php $cod_pregunta = $pregunta['codigo']?>
		<div class='pregunta' style='margin:2.5mm auto; text-align: center'>
			<div class='atributo' style='margin-top: 5mm'><strong style='font-size: 11pt'>Pregunta <?php echo str_pad($idx + 1, 3, '0', STR_PAD_LEFT)?>:</strong></div>
			<div class='atributo'>
				<span>Componente:<br/><?php echo html_select_tag_by_query("preguntas[$cod_pregunta][cod_componente]",'SELECT codigo, nombre FROM i_componentes', null, $pregunta['cod_componente'])?></span>
			</div>
			<div class='atributo'>
				<span>Competencia:<br/><?php echo html_select_tag_by_query("preguntas[$cod_pregunta][cod_competencia]",'SELECT codigo, nombre FROM i_competencias', null, $pregunta['cod_competencia'])?></span>
			</div>
			<div class='atributo'>
				<span>Numeral:<br/><input type='text' name='preguntas[<?php echo $cod_pregunta?>][numeral]' size='4' value='<?php echo $pregunta['numeral']?>'/></span>
			</div>
			<div class='atributo'>
				<span>Respuesta:<br/>
				<?php $respuestas = explode(",", $pregunta['respuesta'])?>
				<?php foreach(range('A','E') as $letra):?>
					<?php echo $letra?><input type='checkbox' name='<?php echo "preguntas[$cod_pregunta][respuesta][]"?>' value='<?php echo $letra?>' <?php echo (in_array($letra, $respuestas))? "checked":"" ?>/>
				<?php endforeach;?>
				</span>
			</div>
			<div class='atributo'>
				<span>Valida:<br/><input type='checkbox' name='preguntas[<?php echo $cod_pregunta?>][valida]' value='<?php echo $pregunta['valida']?>' <?php echo ($pregunta['valida']=='t')? "checked":""?>/></span>
			</div>
			<div class='clear'></div>
		</div>
		<hr style='width:80%'/>
	<?php endforeach;?>
	<input type='hidden' name='action' value='actualizarPreguntas'/>
<?php endif;?>
<div class='button-bar'>
	<button id='actualizarPreguntas' class='flat'>Actualizar</button>
	<button class='flat cancel' id='cancelar-editar-preguntas'>Cancelar</button>
</div>
<div id='respuesta-form-editar-preguntas'></div>
<script>
 $("button#cancelar-editar-preguntas").click(function(){
	  $("div#form-editar-preguntas").html("").slideUp('fast')
	 	$("fieldset div.button-bar button").enable()
	 })
	$("button#actualizarPreguntas").click(function(){
			$.post("../src/icfesGestionarPruebas.php",$("div#form-editar-preguntas input, div#form-editar-preguntas select").serialize(),
					function(html){
						jAlert("LAS PREGUNTAS DE ESTA PRUEBA HAN SIDO ACTUALIZADAS",'ACTUALIZACION EXITOSA', function(){
							$("div#form-editar-preguntas").html("").slideUp('fast')
							$("fieldset div.button-bar button").enable()
						})
			})
		})
</script>