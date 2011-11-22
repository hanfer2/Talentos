<?php /* Smarty version 2.6.26, created on 2011-11-17 00:09:15
         compiled from modules/sesion/templates/login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', 'modules/sesion/templates/login.tpl', 11, false),)), $this); ?>
<div id='main-section-layout'>
	<div class="center" id='wrapper-login' style='min-height: 600px'>
		<h1 class='main-header'>Sistema de Informaci&oacute;n WEB</h1>
		<h2  class='main-header'>Plan Talentos</h2><br/>
		<div class="ui-widget decorated" id="container-login">
			<h1> Ingreso al Sistema</h1>
			<div id="container-linkManual">
				<a href = "../manualEST.pdf" rel="external">Instructivo Men&uacute; Estudiantes</a>
			</div>

			<form method="post" id="form-login" action="<?php echo smarty_function_url_for(array('controller' => 'sesion','action' => 'login'), $this);?>
" >
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
				<?php if (isset ( $this->_tpl_vars['current_url'] )): ?>
					<input type="hidden" name="current_url" value="<?php echo $this->_tpl_vars['current_url']; ?>
"/>
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>