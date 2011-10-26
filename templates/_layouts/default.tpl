<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset={$smarty.const.CHARSET}"/>
    <meta name="Autor" content="Dintev"/>
    
    {include_public file=includes}
    {$__extraHeaders}
		{include_script file='script'}	
    <title>{#PREFIX_PAGETITLE#} {$pageTitle}</title>
  </head>
  <body>
  <div class="non-printable" id='header-section-layout'>
    {include_public file="header"}
    {if is_root_login() or is_bg_user()}
      {include_public file="web_debug"}
    {/if}
    {if is_user_login() }
      {include_public file="menu"}
    {else}
      <div style="height:38px; margin-bottom:5mm"></div>
    {/if}
  </div>
  <div id='main-section-layout'>
		{if ! is_blank($__flash)}
		<div class='notification-flash ui-widget ui-state-error ui-corner-all non-printable'>
			<span class='ui-icon ui-icon-alert left-icon'></span>NOTICE: {$__flash}
		</div>
		{/if}
  {include file="$content_for_layout"}
  </div>
  <div class="non-printable" id='foot-section-layout'>
  {include_public file='footer'}
  </div>
</body>
</html>
