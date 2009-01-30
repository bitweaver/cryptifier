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
		'content_service_icons_tpl' => 'bitpackage:cryptifier/cryptifier_service_icons.tpl',
		'content_edit_mini_tpl' => 'bitpackage:cryptifier/cryptifier_store_content.tpl'
	) );

	function cryptifier_content_display( &$pContent ) {
		if( $pContent->getPreference( 'cryptifier_cipher' ) ) {
		}
	}

	function cryptifier_content_edit( &$pObject ) {
		global $gBitSystem, $gBitSmarty;
		if( $pObject->getPreference( 'cryptifier_cipher' ) ) {
			if( !isset( $_REQUEST['cryptifier_cipher_key'] ) ) {
				$gBitSmarty->assign_by_ref( 'gCryptContent', $pObject );
				$gBitSystem->display( "bitpackage:cryptifier/cryptifier_authenticate.tpl", "Decryption Authenitication" );
				die;
			} else {
				$pObject->mInfo['data'] = cryptifier_decrypt_data( $pObject->mInfo['data'], $pObject->getPreference( 'cryptifier_cipher' ), $_REQUEST['cryptifier_cipher_key'], $pObject->getPreference( 'cryptifier_iv' ) );			
			}
		}
	}

	function cryptifier_content_verify( &$pContent, &$pParamHash ) {
		if( !empty( $pParamHash['cryptifier_active'] ) ) {
			if( empty( $pParamHash['cryptifier_cipher_key'] ) ) {
				$pContent->mErrors['cryptifier'] = "Empty encryption passwords are not valid.";
			} else {
				// no history for encrypted content
				$pParamHash['has_no_history'] = TRUE;
			}
		}
	}

	function cryptifier_content_store( &$pContent, &$pParamHash ) {
		global $gBitSystem;
		if( !empty( $pParamHash['cryptifier_active'] ) ) {
			$cipher = $gBitSystem->getConfig( 'cryptifier_default_cipher', 'blowfish' ); 
			$iv = '';
			$encryptedData = cryptifier_encrypt_data( $pParamHash['content_store']['data'], $cipher, $pParamHash['cryptifier_cipher_key'], $iv );
			$pContent->storePreference( 'cryptifier_cipher', $cipher );
			$pContent->storePreference( 'cryptifier_iv', $iv );
			$pContent->mDb->query( "UPDATE `".BIT_DB_PREFIX."liberty_content` SET `data`=? WHERE `content_id`=? ", array( $encryptedData, $pContent->mContentId ) );
		}
	}

	function cryptifier_encrypt_data( $pData, $pCipher, $pKey, &$pIv ) {
		global $gBitSytem;
		$ret = NULL;
		if( empty( $pCipher ) ) {
			$pCipher = $gBitSystem->getConfig( 'cryptifier_default_cipher', 'blowfish' );
		}
		if( $descriptor = mcrypt_module_open( $pCipher, '',  MCRYPT_MODE_CBC, '' ) ) {
			$pIv = mcrypt_create_iv ( mcrypt_enc_get_iv_size( $descriptor ), MCRYPT_RAND );
			mcrypt_generic_init( $descriptor, $pKey, $pIv );
			$ret = mcrypt_generic( $descriptor, $pData );
			mcrypt_generic_deinit( $descriptor );
			mcrypt_module_close( $descriptor );
		}
		return $ret;
	}

	function cryptifier_decrypt_data( $pData, $pCipher, $pKey, $pIv ) {
		global $gBitSytem;
		$ret = '';
		if( $descriptor = mcrypt_module_open( $pCipher, '',  MCRYPT_MODE_CBC, '' ) ) {
			/* Initialize encryption module for decryption */
			mcrypt_generic_init($descriptor, $pKey, $pIv);
			//remove possible null padding that may have occured during encryption
			$ret = trim( mdecrypt_generic($descriptor, $pData ) );
			mcrypt_generic_deinit($descriptor);
			mcrypt_module_close($descriptor);
		}
//		$ret = mcrypt_decrypt( $pCipher, $pKey, $pData, MCRYPT_MODE_CBC, $pIv );
		return $ret;
	}

}
?>
