{if !isset($cod_programa)}
	{include_template file='programa.form' title='Informe de Participantes'}
	<div class='ajax-response' id='ajax-informe-participantes'></div>
{else}

<div class='ui-widget decorated' id="wPanel-reporte-Participantes">
	<h1>Informe de Participantes</h1>
	<h2>{nombre_programa}</h2>
	<h3>{'now'|date_format}</h3>
	<h4>Total Estudiantes {$oInforme->nombreEstadoEstudiantes}S: {$oInforme->total}</h4>
	<div class='ui-toolbar'><a href='#' class='link-print'>Imprimir</a></div>
	
	<div id='wrapper-reporte-participantes' class="wp frm-9">
		<div class="sidebar wp-l frm-1-5 sb-r" id="menu-reporte-Participantes">
			<h2 class="ui-state-default">Men&uacute;</h2>
			<a href="#reporte-Edad">Edad</a>
			<a href="#reporte-Genero">G&eacute;nero</a>
			<a href="#reporte-Estrato">Estrato</a>
			<a href="#reporte-Comuna">Comuna</a>
			<a href="#reporte-ComunaPredominante" title="Comuna Predominante">Comuna Predom.</a>
			<a href="#reporte-Excepcion">Est. Excepci&oacute;n</a>
			<a href="#reporte-Colegio">Colegios</a>
		</div>
		
		<div id="content-reporte-participantes" class="panel-main-content wp-l frm-7">
			<div class="p-content-item " id="#reporte-Default">{include_partial file="informe/default"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Edad">{include_partial file="informe/edades" }</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Genero">{include_partial file="informe/generos"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Estrato">{include_partial file="informe/estratos"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Comuna">{include_partial file="informe/comunas"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-ComunaPredominante">{include_partial file="informe/comunas_cursos"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Excepcion">{include_partial file="informe/excepciones"}</div>
			<div class="p-content-item ui-helper-hidden" id="reporte-Colegio">{include_partial file="informe/colegios"}</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="date-report"> Generado: <span class="date">{'now'|date_format:#TIMESTAMP_FORMAT#}</span></div>
</div>
{/if}
