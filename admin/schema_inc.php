<?php
global $gBitInstaller;
$gBitInstaller->registerPackageInfo( CRYPTIFIER_PKG_NAME, array(
	'description' => "Encryption and decription of content.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( CRYPTIFIER_PKG_NAME, array(
	array( CRYPTIFIER_PKG_NAME, 'cryptifier_default_cipher','blowfish' ),
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( CRYPTIFIER_PKG_NAME, array(
	array('p_cryptifier_encrypt_content', 'Can encrypt content', 'editors', CRYPTIFIER_PKG_NAME),
	array('p_cryptifier_decrypt_content', 'Can decrypt content', 'editors', CRYPTIFIER_PKG_NAME),
) );
?>
