<p class="empty-result-message">
	<span class='ui-state-error-text'><span class="ui-icon left-icon ui-icon-alert"></span></span>
	{$message|default:"No se hallaron resultados"}
	<span class="clear"></span>
</p>
{if isset($links)}
<div class="ui-toolbar">
	{$links}
</div>
{/if}
