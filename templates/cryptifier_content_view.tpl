{if $gContent->getPreference('cryptifier_cipher') && $smarty.request.cryptifier_cipher_key}
<div class="cryptifiernotice">
	{biticon ipackage="cryptifier" iname="shield_warning" style="height:32px;width:32px;float:left" iexplain="note"}
	{tr}The following information was stored as encrypted data. If the data is unreadable, the incorrect password was entered.{/tr}
</div>
{/if}
