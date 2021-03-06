{if $gBitUser->hasPermission('p_cryptifier_encrypt_content')}
	 {if $smarty.request.cryptifier_cipher_key || !$gContent->getPreference('cryptifier_scope')}
<div class="form-group">
	{forminput label="checkbox"}
		<input type="checkbox" id="cryptifier_active" name="cryptifier_active" value="true" {if $gContent->getPreference('cryptifier_cipher') || $smarty.request.cryptifier_active}checked="checked"{/if} onClick="updateCipherMenu();" /> {tr}Encrypt Data{/tr}
	{/forminput}
</div>
<div class="form-group" id="cryptifieredit" style="display:none">
	{formfeedback error=$gContent->mErrors.cryptifier|default:"You must reenter the ecryption password with every edit."}
	{formlabel label="Encryption Password"}
	{forminput}
		<input class="form-control" type="text" name="cryptifier_cipher_key" value="{$smarty.request.cryptifier_cipher_key}" />
		{formhelp note="This password will NOT be stored. If it is forgotten, this data will be unrecoverable."}
	{/forminput}
	{formlabel label="Encryption Scope"}
	{forminput}
	<select name="cryptifier_scope" id="cryptifierscope" onchange="updateCryptifierScope();" class="form-control">
		<option value="blurb" {if $gContent->getPreference('cryptifier_scope')=='blurb'}selected="selected"{/if}>{tr}Short Blurb{/tr}</option>
		<option value="all" {if $gContent->getPreference('cryptifier_scope')=='all'}selected="selected"{/if}>{tr}Entire Page{/tr}</option>
	</select>
	{/forminput}
	<div class="form-group" id="cryptifierblurb" style="display:none">
		{formlabel label="Encrypted Blurb"}
		{forminput}
			<textarea class="form-control" name="cryptifier_blurb">{$gContent->getField('decrypted_blurb')}</textarea>
			{formhelp note="This password will NOT be stored. If it is forgotten, this data will be unrecoverable."}
		{/forminput}
	</div>
</div>
<script type="text/javascript">//<![CDATA[
{literal}
function updateCryptifierScope() {
	if( document.getElementById( 'cryptifierscope' ).value == 'blurb' ) {
		BitBase.showById( 'cryptifierblurb' );
	} else {
		BitBase.hideById( 'cryptifierblurb' );
	}
}
function updateCipherMenu() {
	if( BitBase.getElementValue( 'cryptifier_active' ) ) {
		BitBase.showById( 'cryptifieredit' );
	} else {
		BitBase.hideById( 'cryptifieredit' );
	}
}
updateCipherMenu();
updateCryptifierScope();
{/literal}
//]]></script>
	{elseif $gContent->getPreference('cryptifier_scope')}
<div class="form-group" id="cryptifieredit">
	{formlabel label="Encrypted data"}
	{forminput}
 		This page has an encrypted blurb, however you did not enter the password to decrypt it. It will remain unchanged.
		<input type="hidden" name="skip_decrypt" value="1"/>
	{/forminput}
</div>
	{/if}
{/if}
