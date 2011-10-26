<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset={$smarty.const.CHARSET}"/>
    <meta name="Autor" content="Dintev"/>
    
    <link rel="icon" href="./templates/_public/img/favicon.ico"/>
    
    {include_script file='jquery'}
		{include_script file='jquery-ui'}

		{include_script file='estilo' type='CSS'}
		{include_script file='jquery-ui' type='CSS'}
		{include_script file='menu' type='CSS'}

    <title>{#PREFIX_PAGETITLE#} {$pageTitle}</title>
  </head>
  <script type="text/javascript">
  {literal}
  jQuery(function($){
		$("a.jm-submenu").append("<span class='ui-icon jm-icon'/>")
	})
  {/literal}
  </script>
  <body>
  <div class="non-printable" id='header-section-layout'>
    {include_public  file="header"}
    {if is_user_login() }
      {include_public file="menu"}
    {else}
      <div style="height:38px; margin-bottom:5mm"></div>
    {/if}
  </div>
  <div id='main-section-layout'>
  {include file="$content_for_layout"}
  </div>
  <div class="non-printable" id='foot-section-layout'>
  {include_public file='footer'}
  </div>
</body>
</html>
