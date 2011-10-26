 <div class="ui-field">
  <label>Componente</label>
  {html_select name="curso_componente[cod_componente]" options=$componentes selected=$curso.componente}
</div>
<div class="ui-field">
  <label for="curso_especial_curso_alias">Nombre Grupo</label>
  <input name="curso[alias]" id="curso_especial_curso_alias" value="{$curso.alias}"/>
  <input name="curso[cod_programa]" value="{$cod_programa}" type="hidden"/>
</div> 
