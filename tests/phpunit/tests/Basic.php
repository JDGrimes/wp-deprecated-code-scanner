<?php

/**
 * Basic testcase class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\PHPUnit\Test;

use WP_Deprecated_Code_Scanner\PHPUnit\TestCase;

/**
 * Basic testcase.
 *
 * @package WP_Deprecated_Code_Scanner\PHPUnit\Test
 * @since   0.1.0
 */
class Basic extends TestCase {

	/**
	 * @since 0.1.0
	 */
	public function expectations() {
		return [
			'function' => [
				[
					'version' => '4.8.0',
					'type'    => 'function',
					'element' => 'a',
					'alt'     => null,
				],
				[
					'version' => '4.5',
					'type'    => 'function',
					'element' => 'c',
					'alt'     => 'd',
				],
			],
			'method' => [
				[
					'version' => '1.2.3',
					'type'    => 'method',
					'element' => 'A::b',
					'alt'     => null,
				],
			],
		];
	}
}

// EOF
