<p class="empty-result-message">
	<span class="ui-icon ui-icon-error inline-icon ui-icon-alert"></span>
	{$message|default:"No se hallaron resultados"}
	<span class="clear"></span>
</p>
{if isset($links)}
<div class="ui-toolbar">
	{$links}
</div>
{/if}
