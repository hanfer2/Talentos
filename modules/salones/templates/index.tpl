<div class="ui-widget decorated">
{if !empty($salones)}
  <h1>Listado de Salones</h1>  
  <table class="table dataTable" id="table-listadoSalones" width="450px">
    <thead>
      <tr>
				<th class='column-select-filter'>Sede</th>
        <th class='column-select-filter'>Edificio</th>				
				<th>Salon</th>
			</tr>
    </thead>
    <tbody>
			{foreach from=$salones item=salon}
        <tr>          
          <td>{$salon.sede}</td>
          <td>{$salon.edificio}</td>
          <td>{$salon.salon}</td>					
        </tr>
      {/foreach}
    </tbody>
  </table>  
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
{else}
	<h1>No se hallaron registros</h1>
	<p>No se hallaron salones</p>
{/if}
  <div class="ui-toolbar">
    <a href="#" id="link-crearSalon">Registrar Nuevo Sal&oacute;n</a>
  </div>
  <div id="wrapper-form-nuevoSalon" class="ui-helper-hidden boxed">
    {include_partial file=add.tpl}
  </div>
  <script type="text/javascript">
    {literal}
    $("#link-crearSalon").click(function(){
      $("#wrapper-form-nuevoSalon").slideToggle();
      return false;
    })
    {/literal}
  </script>
</div>
{if isset($message)}
	<script type='text/javascript'>jAlert("{$message}")</script>
{/if}
