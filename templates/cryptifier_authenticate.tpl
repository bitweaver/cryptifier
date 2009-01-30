{if $gCryptContent}
{strip}
<div class="body">
	{formfeedback error=$failedLogin}

	{form action=$smarty.server.REQUEST_URI legend="Encrypted Data"}
	<input type="hidden" name="content_id" value="{$gCryptContent->mContentId}" />

	<p>{tr}This information is encrypted.{/tr}</p>

	<div class="row">
		{formlabel label="<img src='`$smarty.const.CRYPTIFIER_PKG_URL`icons/1.png' alt='' style='width:48px'/>" for="try-access-answer"}
		{forminput}
			<h3>{tr}Encryption Passowrd{/tr}</h3>
			<input type="password" name="cryptifier_cipher_key" value="" maxlength="128" size="50"/>
			<input type="submit" name="submit_answer" value="Submit"/>
		{/forminput}
	</div>
	{/form}
</div><!-- end .body -->
{/strip}
{/if}

