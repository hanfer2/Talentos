<div class="wrapper-programas-componentes" id="wrapper-programas-componentes-{$semestre}">
	<h4 class="ui-state-default">COMPONENTES 
		{if $siat_user->isRoot()}
      {if $isProgramaClosed}
        <span class="ui-icon ui-icon-locked right-icon"></span>
      {else}
        <span class="ui-icon ui-icon-wrench right-icon clickable edit-icon" title="Editar"></span>
      {/if}
		{/if}
	</h4>
	{include_partial file="_list.tpl" componentes=$componentes}
	
	{if $siat_user->isRoot()}
	<div class="dialog-componentes-edit"></div>
	{/if}
	
</div>
