<?php
global $gBitInstaller;
$tables = array(
	// name and value are reserved database names and should be changed for something else
	'cryptifier_blurbs' => "
		content_id I4 NOTNULL PRIMARY,
		encrypted_data X NOTNULL
		CONSTRAINT '
			, CONSTRAINT `meta_associations_content_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content`( `content_id` )
		'
	",
);
foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( CRYPTIFIER_PKG_NAME, $tableName, $tables[$tableName] );
}

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
