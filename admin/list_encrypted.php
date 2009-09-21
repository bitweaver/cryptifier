<?php

require_once( '../../bit_setup_inc.php' );

// only admins may use this page
$gBitSystem->verifyPermission( 'p_cryptifier_admin' );


$gBitSmarty->assign( 'encryptedBlurbs', cryptifier_get_encrypted_blurbs() );
$gBitSmarty->assign( 'encryptedContent', cryptifier_get_encrypted_content() );
$gBitSystem->display('bitpackage:cryptifier/admin_list_encrypted_content.tpl', 'List Encrypted Content');

