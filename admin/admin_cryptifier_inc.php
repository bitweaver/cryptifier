<?php
require_once( '../../bit_setup_inc.php' );

$gBitSystem->verifyPermission( 'p_admin' );

$ciphers = array( 
MCRYPT_3DES => '3DES',
MCRYPT_BLOWFISH => 'Blowfish',
MCRYPT_CAST_256 => 'Cast 256',
MCRYPT_LOKI97 => 'Loki97',
MCRYPT_PANAMA => 'Panama',
MCRYPT_RIJNDAEL_256 => 'Rijndael 256',
MCRYPT_SAFERPLUS => 'SaferPlus',
MCRYPT_SKIPJACK => 'Skipjack',
MCRYPT_THREEWAY => 'Threeway',
MCRYPT_TRIPLEDES => 'TripleDES',
MCRYPT_TWOFISH256 => 'TwoFish 256',
MCRYPT_WAKE => 'Wake',
MCRYPT_XTEA => 'Xtea',
);

$gBitSmarty->assign( 'ciphers', $ciphers );

if( !empty( $_POST ) ) {
	$gBitSystem->storeConfig( 'cryptifier_default_cipher', $_REQUEST['cryptifier_default_cipher'] );
}

?>
