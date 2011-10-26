{if isset($cod_prueba)}
  {if isset($cedula)}
    {if $cod_interno == null}
      <div class="ui-wdiget decorated">
        <h1>Registrar Promedio Icfes</h1>
        <p>Usuario {$cedula} No Hallado</p>
      </div>
    {else}
      <div class="ui-widget decorated">
        {if $icfes == null}
        <h1>Registrar Promedio Icfes</h1>
        {else}
        <h1>Confirmar Promedio Icfes</h1>
        {/if}
        <h2>{$cedula} - {$nombre_persona}</h2>
        <h3>{$nombre_prueba}</h3>
        <form action="{url_for action=create}" method="post" id="form-registrarIcfes">
          {if $nombre_digitador != null}
            <p>Digitado Por: {$nombre_digitador}</p>
          {/if}
          <div>
            <label>Num. Registro</label>
            <input name="icfes[num_registro_icfes]" value="{$icfes.num_registro_icfes}"  id="icfes_num_registro_icfes" maxlength="15"/><br/><br/>
            <label>Lenguaje</label>
            <input name="icfes[lenguaje]" value="{$icfes.lenguaje}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Matemática</label>
            <input name="icfes[matematica]" value="{$icfes.matematica}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Sociales</label>
            <input name="icfes[sociales]" value="{$icfes.sociales}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Filosofía</label> 
            <input name="icfes[filosofia]" value="{$icfes.filosofia}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Biología</label>
            <input name="icfes[biologia]" value="{$icfes.biologia}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Química</label>
            <input name="icfes[quimica]" value="{$icfes.quimica}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Física</label>
            <input name="icfes[fisica]" value="{$icfes.fisica}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label>Idioma</label>
            <input name="icfes[idioma]" value="{$icfes.idioma}" style='width:50px' maxlength="5" class="numeric"/><br/>
            <label style="margin-left:135px">Interdisciplinar</label>
            <input name="icfes[interdisciplinar]" value="{$icfes.interdisciplinar}" style='width:50px' maxlength="5" class="numeric"/>
            {html_select name="icfes[cod_interdisciplinar]" options=$interdisciplinar selected=$icfes.cod_interdisciplinar id="select-profundizacion"}<br/>
          </div>
          <input type="hidden"  name="icfes[cod_interno]" value="{$cod_interno}" />
          <input type="hidden"  name="icfes[tipo]" value="{$cod_prueba}" />
          
          <input type="hidden"  name="cedula" value="{$cedula}" />
          
          <button type="button" onclick="return validarCambios()">Aceptar</button>

        </form>
        
        <script type="text/javascript">
        {** 
          {if $icfes != null}
            var default = {
              'icfes_num_registro_icfes': {$icfes.num_registro_icfes},
              'lenguaje': {$icfes.lenguaje},
              'matematica': {$icfes.matematica},
              'sociales': {$icfes.sociales},
              'filosofia': {$icfes.filosofia},
              'biologia': {$icfes.biologia},
              'quimica': {$icfes.quimica},
              'fisica': {$icfes.fisica},
              'idioma': {$icfes.idioma}
            }
          {/if}
          **}
        </script>
        
       
        <script type="text/javascript">
        var MAX_VALUE = {if is_root_login()}130{else}100{/if}; 
        {literal}   
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
            location.href= url_for('icfes','add');
          }
          $(function(){
            $("#form-registrarIcfes").bind('submit', function(){
              var hasErrors = false;
              var jqNumRegistro = $("#icfes_num_registro_icfes", this)
              if(jqNumRegistro.val() == ""){
                jqNumRegistro.addClass("error");
                jAlert('El Número del Registro es un Campo Obligatorio');
                return false;
              }
              $(".numeric", this).each(function(){
                var dValue  = parseFloat(this.value);
                
                if(this.value == "" || isNaN(dValue) || dValue >= MAX_VALUE || dValue < 0){
                  $(this).addClass("error");
                  jAlert('Los puntajes deben ser valores numéricos entre 0 y '+MAX_VALUE+'. Por favor revisar.');
                  hasErrors = true;
                  return false;
                }else{
                   $(this).removeClass("error");
                }
              });
              return ! hasErrors;
            });
          });
        {/literal}
        </script>
      </div>
    {/if}
  {else}
    {include_template file="persona.form" title="Registrar Promedio Icfes" subtitle=$nombre_prueba}
    <script type="text/javascript">
      var cod_prueba = {$cod_prueba}
      BusquedaPorApellido.config.cod_programa = "CURRENT";
      BusquedaPorApellido.config.cod_tipo_per = 1;
      BusquedaPorApellido.config.cod_estado = 11;
    </script>
    <div class="ajax-request" id="ajax-registrarPromedioIcfes"></div>
  {/if}
{else}
  {include_template file='programas_icfes' title="Registrar Promedio Icfes - Seleccionar Prueba"}
  <div class="ajax-request" id="ajax-registrarPromedioIcfes-SeleccionarPrueba"></div>
{/if}
