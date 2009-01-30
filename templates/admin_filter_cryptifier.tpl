{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin liberty">
	<div class="header">
		<h1>{tr}Cryptifier Configuration{/tr}</h1>
	</div>

	<div class="body">
		{form}
		{formfeedback hash=$feedback}
		{legend legend="Filter Settings"}
			<div class="row">
				{formlabel label="Default Encryption Algorithm" for=$item}
				{forminput}
					{html_options name="cryptifier_default_cipher" options=$ciphers selected=$gBitSystem->getConfig('cryptifier_default_cipher')}
					{formhelp note=`$output.note` page=`$output.page`}
				{/forminput}
			</div>
			<div class="row submit">
				<input type="submit" name="change_prefs" value="{tr}Save{/tr}" />
			</div>
		{/legend}
		{/form}
	</div><!-- end .body -->
</div><!-- end .liberty-->
{/strip}
