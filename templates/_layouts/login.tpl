<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset={#charset#}"/>
    <meta name="Autor" content="Dintev"/>
    <link rel="icon" href="./templates/_public/img/favicon.ico"/>
    {include_script file='jquery' type='js'}
    {include_script file='jquery-ui' type='js'}
    {include_script file='utils' type='js'}
    {include_script file='login' type='js' module=sesion}
    
    {include_script file='estilo' type='css'}
    {include_script file='sesion_login' type='css' module=sesion}
    <title> Plan de Nivelaci&oacute;n Acad&eacute;mica</title>
</head>
<body id='login-template' >
  {include_public file='header'}
  <hr/>
  {include file="$content_for_layout"}
  <div id='footer-panel' >
    <div id="footer-address">{#FOOTER_TEXT#}</div><br/>
    <p class="w3c-validator">
      <a href="http://validator.w3.org/check?uri=referer">
        <img src="http://www.w3.org/Icons/valid-xhtml10"
              alt="Valid XHTML 1.0 Strict" height="31" width="88" />
      </a>
    </p>
  </div>
	{if !is_blank($message)}
	<script type='text/javascript'>
		jAlert("{$message}", "Error");
	</script>
	{/if}
</body>
		{if date(n) == 12}
			{include_script file='jsnow'}	
    {/if}
</html>

