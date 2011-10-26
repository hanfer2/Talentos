<div id='logoTalentos-panel'>
  <div id='logoTalentos-wrapper' class="{if is_user_login()}panel-logged{else}panel-unlogged{/if}">
    <div class='logo' id='logoUV'>
      <a href = "http://www.univalle.edu.co" >
      <img src="Univalle.png" alt="Universidad del Valle"/>
      </a>
    </div>
    <div id="container-tituloSIAT">
      <h1 style=''>Sistema de Informaci&oacute;n Acad&eacute;mico</h1>
      <h2>Plan Talentos</h2>
    </div>
    <div class='logo' id='logoTalentos'>
			<map name="logos_talentos" id="logos_talentos"> 
				<area shape="rect" coords="0,50,55,110" href="http://www.cali.gov.co/educacion/" target="_blank" title="Portal Secretar&iacute;a de Educaci&oacute;n Municipal" alt="Portal SEM"/> 
				<area shape="rect" coords="56,50,133,110" href="http://www.cali.gov.co/" target="_blank" title="Portal Alcald&iacute;a Santiago de Cali" alt="Portal Alcaldía"/> 
				<area shape="rect" coords="134,0,280,110" href="http://talentos.univalle.edu.co/" target="_top" title="Portal Talentos" alt="Portal Talentos"/> 
			</map>
      <a href = "http://talentos.univalle.edu.co">
      	<img src='talentos.png'  height="80" alt='Logo Talentos' usemap="logos_talentos"/>
      </a>
    </div>
  </div>
  <div id="logged-name-panel">
    {if is_user_login()}
    Conectado como: 
    <strong>{link_to name='fullname'|user_logged_info controller='personas' action='view' cedula=$smarty.session.user.cedula id='link-logged_user_info' class='link'}</strong>
     {if is_root_login()}
			<a href="#" id="link-loginAs" title="Ingresar como..."><span class="ui-icon ui-icon-transferthick-e-w inline-icon error-icon"></span></a>
     {elseif user_logged_info('bg_user') != null}
      <a href="#" id="link-unloginAs" title="Volver a ingresar como el usuario inicial"><span class="ui-icon ui-icon-arrowrefresh-1-s inline-icon error-icon"></span></a>
     {/if}
    {/if}
  </div>
</div>
