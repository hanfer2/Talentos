<h3 class="ui-state-default ui-corner-top"><span class="counter">{$counter}.</span> Asignar Cursos</h3>
<form action="{url_for action=asignar_cursos}" method="post" class="frm-3">
  <p><span class="ui-icon ui-icon-info inline-icon"></span> Este proceso asignará a cada participante un curso en el {#PNAT#}</p>
  <input  type="hidden" name="cod_programa" value="{$cod_programa}"/>
  <button>Asignar Cursos</button>
</form>
