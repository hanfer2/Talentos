  <h2>Registrar Sal&oacute;n en el Sistema</h2>		
	<form action="{url_for action=create}" method='post' id='form-registrarSalon' >		
		<fieldset>
			<div id=''>
				<div class="ui-field">
					<label for='salon_sede'>Sede</label>
					{html_select name='salon[sede]' options=$sedes title='Sede' selected=$salon.sede|default:1}
				</div>
				<div class='ui-field'>
					<label for='salon_edificio'>Edificio</label>
					<input name="salon[edificio]" />
				</div>
				<div class="ui-field">
					<label for="salon_descripcion">Sal&oacute;n</label>					
					<input name="salon[salon]" />
				</div>
			</div>		
		</fieldset>        
		<div class='ui-button-bar'>
			<button id='bt-registrarSalon'>Aceptar</button>
			<button type='button' id='bt-cancelarActualizacion' onclick="location.reload()">Cancelar</button>
		</div>
  </form>
	
