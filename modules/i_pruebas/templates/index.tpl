{if !isset($cod_programa)}
	{include_template file="programa.form" title="Listado de Pruebas" action=index}
	<div class="ajax-response"></div>
{else}
	<div class='ui-widget decorated'>
		<h1>Listado de Pruebas</h1>
		<h2>{$nombre_programa}</h2>
    
    {if $pruebas eq null}
    <p class="ui-state-highlight ui-corner-all notif-block frm-5"><span class="ui-icon ui-icon-alert inline-icon"></span> Este programa aun no reporta pruebas creadas</p>
    {else}
		<table class="table">
      <thead>
        <tr>
          <th class="ui-state-default" rowspan="2">Nombre</th>
          <th class="ui-state-default" rowspan="2">Tipo</th>
          <th class="ui-state-default" rowspan="2">Fecha</th>
          <th class="ui-state-default" colspan="3">Opciones</th>
        </tr>
        <tr>
          <th class="ui-state-default">Visible</th>
          <th class="ui-state-default">Editable</th>
          <th class="ui-state-default">Acciones</th>
        </tr>
			</thead>
			<tbody>
        <!--Siempore esta tomando el codigo 10 cambie el que cambie, antes no tomaba nada-->
			{foreach from=$pruebas item=prueba}
				<tr>
           <input type="hidden" value="{$prueba.codigo}" id="codno"/>
					<td><a class="nombre_prueba" href="{url_for action=view controller=icfes cod_prueba=$prueba.codigo}" id="elcodigo">{$prueba.nombre|escape}</a></td>
					<td>{$prueba.tipo|capitalize}</td><td>{$prueba.fecha|date_format}</td>
					<td><input type="checkbox" class="chk-visibilidadPrueba" name="visibilidad_prueba[{$prueba.codigo}]" value="{$prueba.visible}" {if $prueba.visible eq 't'}checked="checked" {/if}/></td>
          <td>{if $prueba.tipo neq $smarty.const.I_TIPO_SIMULACRO}<input type="checkbox" class="chk-pruebaEditable" name="editable_prueba[{$prueba.codigo}]" value="{$prueba.editable}" {if $prueba.editable eq 't'}checked="checked" {/if}/>{/if}</td>
					<td>
					{if $prueba.tipo eq $smarty.const.I_TIPO_SIMULACRO}
					<a href="#{$prueba.codigo}" class="link-procesarPrueba"><span class="ui-icon ui-icon-play link-icon inline-icon"></span> Procesar</a>
					{/if}
         
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
    {/if}
    
		<div>
      <!--- TOOLBAR-->
      <div class="ui-toolbar">
        <div class="left-icon"><span class="ui-icon ui-icon-gear left-icon link-icon"></span><a href="#" id="link-sysPruebas" class="link">Opciones</a></div>
        <a href="#" id="link-registrarPrueba"><span class="ui-icon ui-icon-plus inline-icon link-icon"></span>Registrar Nueva Prueba</a>
      </div>
      
      <!--- FORM NUEVA PRUEBA-->
      <div class="ui-form boxed hidden frm-3" id="form-registrarPrueba">
        <h1>Registrar Prueba</h1>
        <div class="ui-field">
          <label for="prueba_nombre">Nombre:</label>
          <input name="prueba[nombre]" id="prueba_nombre" class="required" maxlength="20"/>
        </div>
        <div class="ui-field">
          <label for="prueba_tipo">Tipo:</label>
          {html_select name="prueba[tipo]" options=$tipos_icfes}
        </div>
        <div class="ui-field">
          <label for="prueba_fecha">Fecha:</label>
          <input name="prueba[fecha]" id="prueba_fecha" class="date required" />
        </div>
        <input type="hidden" name="prueba[cod_programa]" value="{$cod_programa}"/>
        <div class="ui-button-bar">
          <button id='bt-registrarPrueba'>Aceptar</button>
        </div>
      </div>
      
      <!-- FORM OPCIONES-->
      <div class="ui-form boxed hidden frm-3 ui-widget-content" id="frm-sys-pruebas">
        <h1>Opciones de Configuraci&oacute;n</h1>
        <div class="ui-field">
          <label for="settings_i_prueba_activa">Prueba en Proceso </label>
          {html_select name="settings[i_prueba_activa]" options=$simulacros extra=NULL selected=$prueba_activa}
        </div>
        <div>
          <button id="bt-i_pruebas-guardarConfiguraciones">Aceptar</button>
        </div>
      </div>
      <div class="clear"></div>
    </div>
</div>
{/if}
