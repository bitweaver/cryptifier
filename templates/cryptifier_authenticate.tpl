{if $gCryptContent}
{strip}
<div class="body">
	{formfeedback error=$failedLogin}

	{form action=$smarty.server.REQUEST_URI class="cryptifierauth"}
	<input type="hidden" name="content_id" value="{$gCryptContent->mContentId}" />

	<div class="form-group">
		<div class="formlabel">
			<img src='{$smarty.const.CRYPTIFIER_PKG_URL}icons/shield_key.png' alt='' style='width:48px;'/>
		</div>
		{forminput}
			<h3>{tr}This information is encrypted.{/tr}</h3>
		{/forminput}
	</div>
<div class="clear:both">&nbsp;</div>
	<div class="form-group">
		{formlabel label="Enter Password" for="try-access-answer"}
		{forminput}
			<input type="password" name="cryptifier_cipher_key" value="" maxlength="128" size="50"/>
			<input type="submit" class="btn btn-default" name="submit_answer" value="Submit"/>
			{if $gCryptContent->getPreference('cryptifier_scope') != 'all'}
			<input type="submit" class="btn btn-default" name="skip_decrypt" value="Skip"/>
			{/if}
		{formhelp note="If you are unsure of the password, you can skip this page. However, you will not be able to view or edit encrypted information."}
		{/forminput}
	</div>
	{/form}
</div><!-- end .body -->
{/strip}
{/if}

