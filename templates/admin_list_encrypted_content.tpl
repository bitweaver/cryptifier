{strip}
<div class="floaticon">{bithelp}</div>

<div class="listing cryptifier">
	<div class="header">
		<h1>{tr}{$gBitSystem->getBrowserTitle()}{/tr}</h1>
	</div>

	{formfeedback error=$errors}

	<div class="body">
		{form class="minifind" legend="find in entries"}
			<input type="hidden" name="sort_mode" value="{$sort_mode}" />
			{biticon ipackage="icons" iname="edit-find" iexplain="Search"} &nbsp;
			<label>{tr}Title{/tr}:&nbsp;<input size="16" type="text" name="find_title" value="{$find_title|default:$smarty.request.find_title|escape}" /></label> &nbsp;
			<label>{tr}Author{/tr}:&nbsp;<input size="10" type="text" name="find_author" value="{$find_author|default:$smarty.request.find_author|escape}" /></label> &nbsp;
			<label>{tr}Last Editor{/tr}:&nbsp;<input size="10" type="text" name="find_last_editor" value="{$find_last_editor|default:$smarty.request.find_last_editor|escape}" /></label> &nbsp;
			<input type="submit" name="search" value="{tr}Find{/tr}" />&nbsp;
			<input type="button" onclick="location.href='{$smarty.server.PHP_SELF}{if $hidden}?{/if}{foreach from=$hidden item=value key=name}{$name}={$value}&amp;{/foreach}'" value="{tr}Reset{/tr}" />
		{/form}

		{form id="checkform"}
			<div class="navbar">
				<ul>
					<li>{biticon ipackage="icons" iname="emblem-symbolic-link" iexplain="sort by"}</li>
					<li>{smartlink ititle="Page Name" isort="title" icontrol=$listInfo}</li>
					<li>{smartlink ititle="Last Modified" iorder="desc" idefault=1 isort="last_modified" icontrol=$listInfo}</li>
					<li>{smartlink ititle="Author" isort="creator_user" icontrol=$listInfo}</li>
					<li>{smartlink ititle="Last Editor" isort="modifier_user" icontrol=$listInfo}</li>
					{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list_sort' serviceHash=$gContent->mInfo}
				</ul>
			</div>

			<input type="hidden" name="offset" value="{$offset}" />
			<input type="hidden" name="sort_mode" value="{$sort_mode}" />

			<div class="clear"></div>

			{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='list_options'}


			<dl>
			<dt>{tr}Encrypted blurbs{/tr}</dt>
			{foreach from=$encryptedBlurbs item=content key=contentId}
				<dd>
					<strong><a href="{$smarty.const.BIT_ROOT_URL}index.php?content_id={$contentId}">{$content.title|escape}</a></strong>
					<div class="date">{tr}Created By{/tr}: {displayname user_id=$content.user_id} {tr}on{/tr} {$content.created|bit_short_datetime},<br/>
					{tr}Last modified{/tr}: {$content.last_modified|bit_short_datetime}</div>
				</dd>
			{foreachelse}
				<dt><em>{tr}None{/tr}</em></dt>
			{/foreach}
			<dt>{tr}Encrypted pages{/tr}</dt>
			{foreach from=$encryptedPages item=content key=contentId}
				<dd>
					<strong><a href="{$smarty.const.BIT_ROOT_URL}index.php?content_id={$contentId}">{$content.title|escape}</a></strong>
					<div class="date">{tr}Created By{/tr}: {displayname user_id=$content.user_id} {tr}on{/tr} {$content.created|bit_short_datetime},<br/>
					{tr}Last modified{/tr}: {$content.last_modified|bit_short_datetime}</div>
				</dd>
			{foreachelse}
				<dt><em>{tr}None{/tr}</em></dt>
			{/foreach}
			</dl>
		{/form}
	</div>
</div>
{/strip}
