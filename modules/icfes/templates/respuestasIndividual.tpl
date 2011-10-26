<?php
	 	function valorarRespuesta($respuesta_correcta, $respuesta_escogida){
			if(empty($respuesta_escogida))
				return array('respuesta'=>'-','valoracion'=>'VACIA','sumando'=>1);
			$respuesta_escogida = TIcfes::respuestasEscogidas($respuesta_escogida);
			$valoracion = array('respuesta'=>join(",",$respuesta_escogida));
			if(strlen($respuesta_correcta)==1){
				if(count($respuesta_escogida)>1)
					return array_merge($valoracion, array('valoracion'=>'NULA','sumando'=>1));
				if(in_array($respuesta_correcta, $respuesta_escogida))
					return array_merge($valoracion, array('valoracion'=>' CORRECTA ','sumando'=>1));
				return array_merge($valoracion, array('valoracion'=>'INCORRECTA','sumando'=>1));
			}
			$respuestas_correctas = explode(',',$respuesta_correcta);
			$i = 0;
			foreach($respuestas_correctas as $respuesta){
				if(in_array($respuesta, $respuesta_escogida))
					$i++;
			}
			if($i == 0)
				return array_merge($valoracion, array('valoracion'=>'INCORRECTA','sumando'=>1));
			if($i == count($respuestas_correctas))
				return array_merge($valoracion, array('valoracion'=>' CORRECTA ','sumando'=>1));
			else
				return array_merge($valoracion, array('valoracion'=>'CORRECTA*','sumando'=>0.5));
		}
?>
<div class='decorated ui-widget' >
	<h1>Reporte de Respuestas {info classname=ITipo func=nombre args=$cod_prueba}</h1>
  <h2><?php echo TPersona::nombre($cedula)?></h2>
	<table class='table' border='1' cellpadding='2'>
		<thead style='background-color:#CCC'>
			<tr>
				<th>Componente<br/><span id='select-filter-componentes-by-componente'></span></th>
				<th>Pregunta</th>
				<th>Competencia</th>
				<th>Respuesta<br/>Correcta</th>
				<th>Respuesta<br/>Escogida</th>
				<th>Valoración<br/><span id='select-filter-componentes-by-valoracion'></span></th>
			</tr>
		</thead>
		<tbody>
			<?php $cantidad_preguntas = array();?>
			<?php foreach($_preguntas as $pregunta):?>
			<tr '<?php echo ($pregunta['valida']=='t')? "": "class='strike'"?>'>
				<?php $componente = TIcfes::nombreComponente($pregunta['cod_componente'])?>
				<td><?php echo $componente?></td>
				<td><?php echo $pregunta['numeral']?></td>
				<td><?php echo TIcfes_Competencias::nombre($pregunta['cod_competencia'])?></td>
				<td><?php echo $pregunta['respuesta']?></td>
				<?php $valoracion = valorarRespuesta($pregunta['respuesta'], array_slice(any($_respuestas[$pregunta['codigo']], array()),3,4))?>
				<?php if($pregunta['valida']=='t'):?>
					<?php $_resumen[$componente][$valoracion['valoracion']] = increment($_resumen[$componente][$valoracion['valoracion']], $valoracion['sumando'])?>
					<?php $cantidad_preguntas[$componente] = increment($cantidad_preguntas[$componente])?>
				<?php endif;?>
				<td><?php echo $valoracion['respuesta']?></td>
				<td class='valoracion'><?php echo $valoracion['valoracion']?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<h3 style='margin-top:1cm'>RESUMEN</h3>
	<table id='resumen' class='table' border='1' cellpadding='2'>
		<thead style='background-color:#CCC'>
			<tr>
				<th rowspan='2'>Componente</th>
				<th colspan='4'>Respuestas</th>
				<th rowspan='2'>Total<br/>Preguntas</th>
				<th rowspan='2'>Puntaje</th>
			</tr>
			<tr>
				<th>Correctas</th>
				<th>Incorrectas</th>
				<th>Nulas</th>
				<th>Vacías</th>
			</tr>
		</thead>
		<tbody style='font-weight:bold; font-size:10px'>
			<tr>
				<?php foreach($_resumen as $componente=>$valoraciones):?>
					<th><?php echo $componente?></th>
					<td style='color:blue'><?php echo any($valoraciones[' CORRECTA '],0)?></td>
					<td style='color:red'><?php echo any($valoraciones['INCORRECTA'],0)?></td>
					<td style='color:#7b1c31'><?php echo any($valoraciones['NULA'],0)?></td>
					<td style='color:#ff4500'><?php echo any($valoraciones['VACIA'],0)?></td>
					<td style='font-weight:bold'><?php echo $cantidad_preguntas[$componente] ?></td>
					<td><?php echo number_format($valoraciones[' CORRECTA ']*100/$cantidad_preguntas[$componente],2)?></td>
				</tr>
				<?php endforeach;?>
		</tbody>
	</table>
</div>
<script type="text/javascript">

	$("td.valoracion").each(function(){
		  this.style.fontWeight = 'bold';
			switch($(this).text()){
			  case 'CORRECTA*':
				  $(this).mouseover(function(){
					  	Tip("PARCIALMENTE CORRECTA", ABOVE, true, SHADOW, true, SHADOWWIDTH, 1, TEXTALIGN, 'center', PADDING, 5, BGCOLOR,'#DDD',BORDERCOLOR,'#CCC')
					  })
					$(this).mouseout(function(){UnTip()})
				case ' CORRECTA ': this.style.color='blue'; break;
				case 'VACIA': this.style.color='#ff4500'; break;
				case 'INCORRECTA': this.style.color='red'; break;
				case 'NULA': this.style.color='#7b1c31'; break;
			}
		})
	
</script>