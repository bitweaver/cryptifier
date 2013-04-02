{strip}
		{form action=$smarty.server.REQUEST_URI}
		{formfeedback hash=$feedback}
		{legend legend="Filter Settings"}
			<div class="control-group">
				{formlabel label="Default Encryption Algorithm" for=$item}
				{forminput}
					{html_options name="cryptifier_default_cipher" options=$ciphers selected=$gBitSystem->getConfig('cryptifier_default_cipher')}
					{formhelp note=`$output.note` page=`$output.page`}
				{/forminput}
			</div>
			<div class="control-group submit">
				<input type="submit" name="change_prefs" value="{tr}Save{/tr}" />
			</div>
		{/legend}
		{/form}
{/strip}
