<ul class="dropdown-menu sub-menu">
{if $gBitUser->isAdmin()}
	<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=cryptifier">{tr}Configure{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.CRYPTIFIER_PKG_URL}admin/list_encrypted.php">{tr}List Encrypted Content{/tr}</a></li>
{/if}
</ul>
