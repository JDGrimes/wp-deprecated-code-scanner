<?php

/**
 * A basic test.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

function a() {
	_deprecated_function( __FUNCTION__, '4.8.0' );
}

class A {
	function b() {
		_deprecated_function( __METHOD__, '1.2.3' );
	}
}

function c() {
	_deprecated_function( __FUNCTION__, 4.5, 'd' );
}

// EOF
