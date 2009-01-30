{if $gBitUser->hasPermission('p_cryptifier_encrypt')}
<div class="row">
	{formlabel label="Encrypt Data"}
	{forminput}
		<div><input type="checkbox" id="cryptifier_active" name="cryptifier_active" value="true" {if $gContent->getPreference('cryptifier_cipher')}checked="checked"{/if} onClick="updateCipherMenu();" /></div>
	{/forminput}
</div>
<div class="row" id="cryptifiermenu" style="display:none">
	{formfeedback error=$gContent->mErrors.cryptifier|default:"You must reenter the ecryption password with every edit."}
	{formlabel label="Encryption Password"}
	{forminput}
		<input type="text" name="cryptifier_cipher_key" value="" />
		{formhelp note="This password will NOT be stored. If it is forgotten, this data will be unrecoverable."}
	{/forminput}
</div>
<script type="text/javascript">//<![CDATA[
{literal}
function updateCipherMenu() {
	if( BitBase.getElementValue( 'cryptifier_active' ) ) {
		BitBase.showById( 'cryptifiermenu' );
	} else {
		BitBase.hideById( 'cryptifiermenu' );
	}
}
updateCipherMenu();
{/literal}
//]]></script>
{/if}
