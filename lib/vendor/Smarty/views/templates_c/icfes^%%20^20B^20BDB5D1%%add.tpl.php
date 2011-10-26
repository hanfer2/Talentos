<?php /* Smarty version 2.6.26, created on 2011-07-06 16:54:16
         compiled from ./modules/icfes/templates//add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', './modules/icfes/templates//add.tpl', 17, false),array('function', 'html_select', './modules/icfes/templates//add.tpl', 42, false),array('function', 'include_template', './modules/icfes/templates//add.tpl', 118, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['cod_prueba'] )): ?>
  <?php if (isset ( $this->_tpl_vars['cedula'] )): ?>
    <?php if ($this->_tpl_vars['cod_interno'] == null): ?>
      <div class="ui-wdiget decorated">
        <h1>Registrar Promedio Icfes</h1>
        <p>Usuario <?php echo $this->_tpl_vars['cedula']; ?>
 No Hallado</p>
      </div>
    <?php else: ?>
      <div class="ui-widget decorated">
        <?php if ($this->_tpl_vars['icfes'] == null): ?>
        <h1>Registrar Promedio Icfes</h1>
        <?php else: ?>
        <h1>Confirmar Promedio Icfes</h1>
        <?php endif; ?>
        <h2><?php echo $this->_tpl_vars['cedula']; ?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
        <h3><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h3>
        <form action="<?php echo smarty_function_url_for(array('action' => 'create'), $this);?>
" method="post" id="form-registrarIcfes">
          <?php if ($this->_tpl_vars['nombre_digitador'] != null): ?>
            <p>Digitado Por: <?php echo $this->_tpl_vars['nombre_digitador']; ?>
</p>
          <?php endif; ?>
          <div>
            <label>Num. Registro</label>
            <input name="icfes[num_registro_icfes]" value="<?php echo $this->_tpl_vars['icfes']['num_registro_icfes']; ?>
"  id="icfes_num_registro_icfes" maxlength="15"/><br/><br/>
            <label>Lenguaje</label>
            <input name="icfes[lenguaje]" value="<?php echo $this->_tpl_vars['icfes']['lenguaje']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Matemática</label>
            <input name="icfes[matematica]" value="<?php echo $this->_tpl_vars['icfes']['matematica']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Sociales</label>
            <input name="icfes[sociales]" value="<?php echo $this->_tpl_vars['icfes']['sociales']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Filosofía</label> 
            <input name="icfes[filosofia]" value="<?php echo $this->_tpl_vars['icfes']['filosofia']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Biología</label>
            <input name="icfes[biologia]" value="<?php echo $this->_tpl_vars['icfes']['biologia']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Química</label>
            <input name="icfes[quimica]" value="<?php echo $this->_tpl_vars['icfes']['quimica']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Física</label>
            <input name="icfes[fisica]" value="<?php echo $this->_tpl_vars['icfes']['fisica']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Idioma</label>
            <input name="icfes[idioma]" value="<?php echo $this->_tpl_vars['icfes']['idioma']; ?>
" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label style="margin-left:135px">Interdisciplinar</label>
            <input name="icfes[interdisciplinar]" value="<?php echo $this->_tpl_vars['icfes']['interdisciplinar']; ?>
" style='width:50px' maxlength="5" class="numeric"/>
            <?php echo smarty_function_html_select(array('name' => "icfes[cod_interdisciplinar]",'options' => $this->_tpl_vars['interdisciplinar'],'selected' => $this->_tpl_vars['icfes']['cod_interdisciplinar'],'id' => "select-profundizacion"), $this);?>
<br/>
          </div>
          <input type="hidden"  name="icfes[cod_interno]" value="<?php echo $this->_tpl_vars['cod_interno']; ?>
" />
          <input type="hidden"  name="icfes[tipo]" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
" />
          
          <input type="hidden"  name="cedula" value="<?php echo $this->_tpl_vars['cedula']; ?>
" />
          
          <button type="button" onclick="return validarCambios()">Aceptar</button>

        </form>
        
        <script type="text/javascript">
                </script>
        
       
        <script type="text/javascript">
        var MAX_VALUE = <?php if (is_root_login ( )): ?>130<?php else: ?>100<?php endif; ?>; 
        <?php echo '   
          function fueModificado(){
            return true;
          }
          
          function validarCambios(){
            if(fueModificado())
              $("#form-registrarIcfes").submit() ;
            else
              goToNewForm();
          }
          
          function goToNewForm(){
            location.href= url_for(\'icfes\',\'add\');
          }
          $(function(){
            $("#form-registrarIcfes").bind(\'submit\', function(){
              var hasErrors = false;
              var jqNumRegistro = $("#icfes_num_registro_icfes", this)
              if(jqNumRegistro.val() == ""){
                jqNumRegistro.addClass("error");
                jAlert(\'El Número del Registro es un Campo Obligatorio\');
                return false;
              }
              $(".numeric", this).each(function(){
                var dValue  = parseFloat(this.value);
                
                if(this.value == "" || isNaN(dValue) || dValue >= MAX_VALUE || dValue < 0){
                  $(this).addClass("error");
                  jAlert(\'Los puntajes deben ser valores numéricos entre 0 y \'+MAX_VALUE+\'. Por favor revisar.\');
                  hasErrors = true;
                  return false;
                }else{
                   $(this).removeClass("error");
                }
              });
              return ! hasErrors;
            });
          });
        '; ?>

        </script>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <?php echo smarty_function_include_template(array('file' => "persona.form",'title' => 'Registrar Promedio Icfes','subtitle' => $this->_tpl_vars['nombre_prueba']), $this);?>

    <script type="text/javascript">
      var cod_prueba = <?php echo $this->_tpl_vars['cod_prueba']; ?>

      BusquedaPorApellido.config.cod_programa = "CURRENT";
      BusquedaPorApellido.config.cod_tipo_per = 1;
      BusquedaPorApellido.config.cod_estado = 11;
    </script>
    <div class="ajax-request" id="ajax-registrarPromedioIcfes"></div>
  <?php endif; ?>
<?php else: ?>
  <?php echo smarty_function_include_template(array('file' => 'programas_icfes','title' => "Registrar Promedio Icfes - Seleccionar Prueba"), $this);?>

  <div class="ajax-request" id="ajax-registrarPromedioIcfes-SeleccionarPrueba"></div>
<?php endif; ?>