{if $siat_menu->pruebaActiva neq null}
  {if $siat_menu->getTipoPruebaActiva() eq $smarty.const.I_TIPO_SIMULACRO}
    <li class="menu">{link_to name="Verificar Simulacro" controler="i_cuestionarios_estudiantes" action="view" cod_prueba=$siat_menu->pruebaActiva }</li>
    <li class="menu">{link_to name="Corregir Simulacro" controler="i_cuestionarios_estudiantes" action="edit"}</li>
  {else}
    <li class="menu">{link_to name="Registrar Promedios Icfes" cod_prueba=$siat_menu->pruebaActiva controller=icfes action=add}</li>
  {/if}
{/if}
