{if !isset($cedula)}

<div id="tabs-registrarEgresados">
  <ul>
    <li><a href="#tab-IES">Ingreso Educaci&oacute;n Superior</a></li>
    <li><a href="#tab-trabajador">Reportar como Trabajador</a></li>
  </ul>
  
  {capture name=toolbar}
   <div class="ui-toolbar">
		<a href="#" class="link-buscarPorApellido">Buscar por Apellido</a><br/><br/>
		{link_to name='Listado de Egresados'}
  </div>
	{/capture}
	
  <div class="ui-widget decorated" id="tab-IES">
    <h1>Registro de Egresados<br/>con Ingreso a Educaci&oacute;n Superior</h1>
    <div class="ui-form">
      <div class="ui-field">
        <label>Doc. Id </label>
        <input id="cedula-IES" name="cedula" size="15" class="numeric" value="{$smarty.get.cedula}"/>
      </div>
      <div class="ui-button-bar">
        <button id="bt-seleccionarEstudiante-ies">Aceptar</button>
      </div>
    </div>
    {$smarty.capture.toolbar}
    <div class="ajax-response" id="ajax-egresado-ies"></div>
  </div>

  <div class="ui-widget decorated" id="tab-trabajador">
    <h1>Registro de Egresados<br/>Como Trabajador</h1>
    <div class="ui-form">
      <div class="ui-field">
        <label>Doc. Id </label>
        <input id="cedula-trab" name="cedula" size="15" class="numeric" value="{$smarty.get.cedula}"/>
      </div>
      <div class="ui-button-bar">
        <button id="bt-seleccionarEstudiante-lab">Aceptar</button>
      </div>
    </div>
    {$smarty.capture.toolbar}
    <div class="ajax-response" id="ajax-egresado-lab"></div>
  </div>
  <div  class='ui-form' id='form-buscarPorApellido'>
		{include file='../personas/buscarPorApellido.tpl'}
	</div>
</div>

{else}
	{include_partial file="check_ies.tpl"}
{/if}

