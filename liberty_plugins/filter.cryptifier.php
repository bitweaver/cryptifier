<?php
/**
 * @version  $Header: /cvsroot/bitweaver/_bit_cryptifier/liberty_plugins/filter.cryptifier.php,v 1.2 2009/01/30 17:21:02 spiderr Exp $
 * @package  liberty
 * @subpackage plugins_filter
 */

/**
 * definitions ( guid character limit is 16 chars )
 */
define( 'PLUGIN_GUID_FILTERCRYPTIFIER', 'filtercryptifier' );

global $gLibertySystem;

// Set of default acceptable HTML tags
define( 'DEFAULT_ACCEPTABLE_TAGS', '<a><br><b><blockquote><cite><code><div><dd><dl><dt><em><h1><h2><h3><h4><hr>'
		.'<i><it><img><li><ol><p><pre><span><strong><table><tbody><div><tr><td><th><u><ul>'
		.'<button><fieldset><form><label><input><option><select><textarea>' );

$pluginParams = array (
	// plugin title
	'title'                    => 'Cryptifier',
	// help page on bitweaver org that explains this plugin
	'help_page'                => 'Cryptifier',
	// brief description of the plugin
	'description'              => 'Encrypts and Decrypts content in the database',
	// should this plugin be active or not when loaded for the first time
	'auto_activate'            => FALSE,
	// type of plugin
	'plugin_type'              => FILTER_PLUGIN,
	// url to page with options for this plugin
	'plugin_settings_url'      => KERNEL_PKG_URL.'admin/index.php?page=cryptifier',

	// various filter functions and when they are called
	// called before the data is parsed
	'preparse_function'  => 'cryptifier_prefilter',
	// called after the data has been parsed
	'postparse_function'      => 'cryptifier_postfilter',
	// called before the data is parsed if there is a split
	// 'presplit_function'  => 'cryptifier_filter',
	// called after the data has been parsed if there is a split
	//	'postsplit_function' => 'cryptifier_filter',
	// called before the data is saved
	'prestore_function'	 => 'cryptifier_prestore',
);

$gLibertySystem->registerPlugin( PLUGIN_GUID_FILTERCRYPTIFIER, $pluginParams );

function cryptifier_prestore( &$pData, &$pFilterHash, $pObject ) {
	global $gBitSystem;
}

function cryptifier_prefilter( &$pData, &$pFilterHash, $pObject ) {
	global $gBitSystem, $gBitThemes, $gBitSmarty;
	// Decrypt the content if needed and able

	if( $pObject->getPreference( 'cryptifier_cipher' ) ) {
		if( !empty( $_REQUEST['cryptifier_cipher_key'] ) ) {
			$pData = cryptifier_decrypt_data( $pData, $pObject->getPreference( 'cryptifier_cipher' ), $_REQUEST['cryptifier_cipher_key'], $pObject->getPreference( 'cryptifier_iv' ) );			
		} else {
			$pData = '';
		}
	}
}

function cryptifier_postfilter( &$pData, &$pFilterHash, $pObject ) {
	global $gBitSystem, $gBitThemes, $gBitSmarty;
	if( $pObject->getPreference( 'cryptifier_cipher' ) ) {
		if( empty( $_REQUEST['cryptifier_cipher_key'] ) ) {
			$gBitSmarty->assign_by_ref( 'gCryptContent', $pObject );
			$pData = $gBitSmarty->fetch( "bitpackage:cryptifier/cryptifier_authenticate.tpl" );
		}
	}
}

/*
function gatekeeper_authenticate( &$pInfo, $pFatalOnError = TRUE ) {
	global $gBitSystem, $gBitSmarty;
	$ret = FALSE;

	if( empty( $_SESSION['gatekeeper_security'][$pInfo['security_id']] ) || ( $_SESSION['gatekeeper_security'][$pInfo['security_id']] != md5( $pInfo['access_answer'] ) ) ) {
		if( !empty( $_REQUEST['try_access_answer'] ) && strtoupper( trim( $_REQUEST['try_access_answer'] ) ) == strtoupper( trim($pInfo['access_answer']) ) ) {
			// we have a successful password entry. Set the session so we don't ask for it again
			$_SESSION['gatekeeper_security'][$pInfo['security_id']] = md5( $pInfo['access_answer'] );
		} else {
			if( $pFatalOnError ) {
				$gBitSystem->display("bitpackage:gatekeeper/authenticate.tpl", "Password Required" , array( 'display_mode' => 'display' ));
				die;
			} else {
				$ret = '<h2>'.tra( "Password Required" ).'</h2>'.$gBitSmarty->fetch( "bitpackage:gatekeeper/authenticate.tpl" );
			}
		}
	}
	return $ret;
}
*/
?>
