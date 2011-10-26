<div class='decorated error-page-panel'>
  <h1>USUARIO NO AUTORIZADO</h1>
  {html_image file='warning.png'}
  <p class="err-msg">Usted no está autorizado para acceder a esta aplicación</p>
  { if !is_user_login()}
  <div class="ui-toolbar">
		{link_to name="Ingresar" action='login'}
  </div>
  {/if}
</div>
