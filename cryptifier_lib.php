<?php

	function cryptifier_content_display( &$pContent ) {
		if( $pContent->getPreference( 'cryptifier_cipher' ) && $pContent->getPreference( 'cryptifier_scope' ) == 'blurb' ) {
			if( !empty( $_REQUEST['cryptifier_cipher_key'] ) ) {
				$pContent->mInfo['decrypted_blurb'] = cryptifier_get_blurb( $pContent, $_REQUEST['cryptifier_cipher_key'] );
			}
		}
	}

	function cryptifier_get_blurb( &$pContent, $pCipherKey ) {
		if( $encryptedBlurb = $pContent->mDb->getOne( "SELECT `encrypted_data` FROM `".BIT_DB_PREFIX."cryptifier_blurbs` WHERE `content_id`=?", array( $pContent->mContentId ) ) ) {
			$ret = cryptifier_decrypt_data( $encryptedBlurb, $pContent->getPreference( 'cryptifier_cipher' ), $pCipherKey, $pContent->getPreference( 'cryptifier_iv' ) );			
		}
		return $ret;
	}

	function cryptifier_content_expunge( &$pContent ) {
		$pContent->mDb->query( "DELETE FROM `".BIT_DB_PREFIX."cryptifier_blurbs` WHERE `content_id`=?", array( $pContent->mContentId ) );
	}

	function cryptifier_content_edit( &$pContent ) {
		global $gBitSystem, $gBitSmarty;
		$pContent->verifyUserPermission( 'p_cryptifier_encrypt_content' );

		if( $pContent->getPreference( 'cryptifier_cipher' ) ) {
			if( !isset( $_REQUEST['cryptifier_cipher_key'] ) ) {
				$gBitSmarty->assign_by_ref( 'gCryptContent', $pContent );
				$gBitSystem->display( "bitpackage:cryptifier/cryptifier_authenticate.tpl", "Decryption Authenitication" );
				die;
			} else {
				switch ( $pContent->getPreference( 'cryptifier_scope' ) ) {
					case 'all':
						$pContent->mInfo['data'] = cryptifier_decrypt_data( $pContent->mInfo['data'], $pContent->getPreference( 'cryptifier_cipher' ), $_REQUEST['cryptifier_cipher_key'], $pContent->getPreference( 'cryptifier_iv' ) );			
						break;
					case 'blurb':
						$pContent->mInfo['decrypted_blurb'] = cryptifier_get_blurb( $pContent, $_REQUEST['cryptifier_cipher_key'] );
						break;
				}
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
			$pContent->storePreference( 'cryptifier_cipher', $cipher );
			$gBitSystem->mDb->query( "DELETE FROM `".BIT_DB_PREFIX."cryptifier_blurbs` WHERE `content_id`=?", array( $pContent->mContentId ) );
			if( $_REQUEST['cryptifier_scope'] == 'blurb' && !empty( $_REQUEST['cryptifier_blurb'] ) ) {
					$encryptedData = cryptifier_encrypt_data( $_REQUEST['cryptifier_blurb'], $cipher, $pParamHash['cryptifier_cipher_key'], $iv );
					$gBitSystem->mDb->query( "INSERT INTO `".BIT_DB_PREFIX."cryptifier_blurbs` (`content_id`, `encrypted_data` ) VALUES( ?,? )", array( $pContent->mContentId, $encryptedData ) );
			} elseif( $_REQUEST['cryptifier_scope'] == 'all' ) {
				$encryptedData = cryptifier_encrypt_data( $pParamHash['content_store']['data'], $cipher, $pParamHash['cryptifier_cipher_key'], $iv );
				$pContent->mDb->query( "UPDATE `".BIT_DB_PREFIX."liberty_content` SET `data`=? WHERE `content_id`=? ", array( $encryptedData, $pContent->mContentId ) );
			}
			$pContent->storePreference( 'cryptifier_iv', $iv );
			$pContent->storePreference( 'cryptifier_scope', $_REQUEST['cryptifier_scope'] );
		} else {
			$pContent->storePreference( 'cryptifier_cipher', NULL );
			$pContent->storePreference( 'cryptifier_iv', NULL );
			$pContent->storePreference( 'cryptifier_scope', NULL );
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

?>
