<?php
global $gBitSystem;

define( 'LIBERTY_SERVICE_CRYPTIFIER', 'Cryptogrphy' );

$registerHash = array(
	'package_name' => 'cryptifier',
	'package_path' => dirname( __FILE__ ).'/',
	'activatable' => true,
	'service' => LIBERTY_SERVICE_CRYPTIFIER,
	'homeable'=> FALSE
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'cryptifier' ) ) {
	$gLibertySystem->registerService( LIBERTY_SERVICE_CRYPTIFIER, CRYPTIFIER_PKG_NAME, array(
		'content_display_function' => 'cryptifier_content_display',
		'content_edit_function' => 'cryptifier_content_edit',
		'content_verify_function' => 'cryptifier_content_verify',
		'content_store_function' => 'cryptifier_content_store',
		'content_expunge_function' => 'cryptifier_content_expunge',
		'content_service_icons_tpl' => 'bitpackage:cryptifier/cryptifier_service_icons.tpl',
		'content_edit_mini_tpl' => 'bitpackage:cryptifier/cryptifier_store_content.tpl',
		'content_body_tpl' => 'bitpackage:cryptifier/cryptifier_content_view.tpl',
	) );

	include_once( 'cryptifier_lib.php' );
}
?>
