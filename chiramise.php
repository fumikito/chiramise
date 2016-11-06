<?php
/**
Plugin Name: Chiramise
Plugin URI: https://gianism.info/add-on/chiramise/
Description: A WordPress plugin which makes your contents "members only".
Author: Hametuha INC.
Version: 1.0.0
PHP Version: 5.5.0
Author URI: https://gianism.info/
Text Domain: warifu
*/

$info = get_file_data( __FILE__ , [
	'version'     => 'Version',
	'php_version' => 'PHP Version',
] );

define( 'CHIRAMISE_VERSION', $info['version'] );

load_plugin_textdomain( 'chiramise', false, 'chiramise/languages' );

try {
	if ( ! version_compare( phpversion(), $info['php_version'], '>=' ) ) {
		throw new Exception( sprintf( __( '[Chiramise] PHP <code>%s</code> is required, but your version is <code>%s</code>. So this plugin is still in silence. Please contact server administrator.', 'chiramise' ), phpversion(), $info['php_version'] ) );
	}
	// Load functions
	foreach ( array( 'functions', 'hooks' ) as $dir_name ) {
		$dir = __DIR__.'/'.$dir_name.'/';
		foreach ( scandir( $dir ) as $file ) {
			if ( preg_match( '#^[^.](.*)\.php$#u', $file ) ) {
				require $dir.$file;
			}
		}
	}
} catch ( Exception $e ) {
	$error = sprintf( '<div class="error"><p>%s</p></div>', $e->getMessage() );
	add_action( 'admin_notices', create_function( '', sprintf( 'echo \'%s\';', str_replace( '\'', '\\\'', $error ) ) ) );
}
