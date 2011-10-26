<?php /* Smarty version 2.6.26, created on 2011-09-20 16:33:56
         compiled from modules/programas/templates/add.tpl */ ?>
<div class="ui-form boxed hidden " id="form-registrarNuevoPrograma">
  <h2>Registrar Nuevo <?php echo $this->_config[0]['vars']['PNAT']; ?>
</h2>
    <div class="ui-field">
      <label for="programa_codigo">C&oacute;digo</label>
      <input name="programa[codigo]" id="programa_codigo" title="Código del Programa" maxlength="5" readonly />
    </div>
    <div class="ui-field">
      <label for="programa_nombre">Nombre</label>
      <input name="programa[nombre]" id="programa_nombre" title ="Nombre del Programa" readonly />
    </div>
		<div class="center">
	    <div class='title-section'>SEMESTRE 1</div>
	    <div>
	      <div class="ui-field" >
	        <label for="programa_fecha_inicio_1">Fecha Inicio</label>
	        <input name="programa[fecha_inicio_1]" id="programa_fecha_inicio" class="date" title="Fecha de Inicio del Programa"/>
	      </div>
	      <div class="ui-field">
	        <label for="programa_fecha_cierre_1">Fecha Cierre</label>
	        <input name="programa[fecha_cierre_1]" id="programa_fecha_cierre_1" class="date" title="Fecha Cierre 1º Semestre"/>
	      </div>
	    </div>
	    <div class='title-section'>SEMESTRE 2</div>
	    <div>
	      <div class="ui-field">
	        <label for="programa_fecha_inicio_2">Fecha Inicio</label>
	        <input name="programa[fecha_inicio_2]" id="programa_fecha_inicio_2" class="date" title="Fecha Inicio 2º Semestre "/>
	      </div>
	      <div class="ui-field">
	        <label for="programa_fecha_cierre_2">Fecha Cierre</label>
	        <input name="programa[fecha_cierre_2]" id="programa_fecha_cierre" class="date" title="Fecha Cierre Final"/>
	      </div>
	    </div>
		</div>
    <div class="ui-button-bar">
      <button id="bt-registrarNuevoPrograma">Crear</button>
    </div>
  </div>