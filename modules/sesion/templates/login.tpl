<div id='main-section-layout'>
	<div class="center" id='wrapper-login' style='min-height: 600px'>
		<h1 class='main-header'>Sistema de Informaci&oacute;n WEB</h1>
		<h2  class='main-header'>Plan Talentos</h2><br/>
		<div class="ui-widget decorated" id="container-login">
			<h1> Ingreso al Sistema</h1>
			<div id="container-linkManual">
				<a href = "../manualEST.pdf" rel="external">Instructivo Men&uacute; Estudiantes</a>
			</div>

			<form method="post" id="form-login" action="{url_for controller='sesion' action='login'}" >
				<div class="ui-field" id="field-login">
					<label>Usuario:</label>
					<input name="iLogin" class="numeric" id="iLogin"/>
				</div>
				<div class="ui-field" id="field-passwd">
					<label>Contrase&ntilde;a:</label>
					<input name="iclave" class="numeric" id="iclave" type="password"/>
				</div>
				<div class="ui-button-bar" style="margin-top: 1cm">
					<button onclick="return validarLogin()">Aceptar</button>
				</div>
				{if isset($current_url)}
					<input type="hidden" name="current_url" value="{$current_url}"/>
				{/if}
			</form>
		</div>
	</div>
</div>
