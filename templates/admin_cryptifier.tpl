{strip}
		{form action=$smarty.server.REQUEST_URI}
		{formfeedback hash=$feedback}
		{legend legend="Filter Settings"}
			<div class="form-group">
				{formlabel label="Default Encryption Algorithm" for=$item}
				{forminput}
					{html_options name="cryptifier_default_cipher" options=$ciphers selected=$gBitSystem->getConfig('cryptifier_default_cipher')}
					{formhelp note=$output.note page=$output.page}
				{/forminput}
			</div>
			<div class="form-group submit">
				<input type="submit" class="btn btn-default" name="change_prefs" value="{tr}Save{/tr}" />
			</div>
		{/legend}
		{/form}
{/strip}
