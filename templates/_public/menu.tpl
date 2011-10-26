{**NOTA: Los menues se almacenan en /templates/_public/pages/menu/ ## **}
<div class="ui-sidebar-menu">
  <ul id="top-menubar" class="sf-menu jm-menu ui-state-default">
		{if  is_user_login(COD_TIPO_DIGITA_ICFES)}
      {include_menu file='digita_icfes'}
		{* MENU COMO DOCENTE  *}
		{elseif is_professor_login()}
      {include_menu file='docente'}
		{* MENU COMO ESTUDIANTE *}
		{elseif is_student_login()}
      {include_menu file='estudiante'}
		{elseif  is_user_login(COD_TIPO_VISITANTE_1)}
      {include_menu file='visitante'}
		{* MENU COMO MONITOR/COORDINADOR/ADMINISTRADOR/ROOT*}
    {else}
       {include_menu file=admin"}
    {/if}
    

    <li class="jm-rightItem">
			<a href="{url_for controller='sesion' action='salir'}" title="Cerrar Sesión"><span class="ui-icon ui-icon-power"></span>Salir</a>
		</li>
		{if is_admin_login() or is_coordinator_login()}
			<li class="jm-rightItem">
				<a href="{url_for controller='personas' action='find'}" title="Buscar Usuario"><span class="ui-icon ui-icon-search"></span>Buscar</a>
			</li>
		{/if}
		<li class="jm-clear">&nbsp;</li>
  </ul>
  <div class="clear"></div>
</div>
<div class="clear"></div>

