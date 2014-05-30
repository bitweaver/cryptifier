{if $gContent->getPreference('cryptifier_cipher')}
	{if $smarty.request.cryptifier_cipher_key}
		<div class="cryptifiernotice">
			{biticon ipackage="cryptifier" iname="shield_ok" style="height:32px;width:32px;float:left" iexplain="note"}
			{tr}The following information was stored as encrypted data. If the data is unreadable, the incorrect password was entered.{/tr}
			{if  $gContent->getPreference('cryptifier_scope') == 'blurb'}
				<div class="clear">
				<div class="form-group">
					{formlabel label="Decrypted Information"}
					{forminput}
						{$gContent->getField('decrypted_blurb')}
					{/forminput}
				</div>
				</div>
			{/if}
		</div>
	{elseif  $gContent->getPreference('cryptifier_scope') == 'blurb'}
		{form action=$smarty.server.REQUEST_URI class="cryptifierauth"}
			<img src='{$smarty.const.CRYPTIFIER_PKG_URL}icons/shield_key.png' alt='' style='margin-bottom:-8px;width:24px;'/>
			{tr}This page contains encrypted data.{/tr} <strong>{tr}Enter password{/tr}</strong>
			<input type="password" name="cryptifier_cipher_key" value="" maxlength="128" />
			<input type="submit" class="btn btn-default" name="submit_answer" value="Submit"/>
		{/form}
	{/if}
{/if}
