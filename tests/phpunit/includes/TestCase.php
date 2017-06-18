<?php

/**
 * PHPUnit testcase class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\PHPUnit;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use WP_Deprecated_Code_Scanner\Collector;
use WP_Deprecated_Code_Scanner\Config;
use WP_Deprecated_Code_Scanner\NodeVisitor;

/**
 * Main testcase for the PHPUnit tests.
 *
 * @package WP_Deprecated_Code_Scanner\PHPUnit
 * @since   0.1.0
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Runs a test that scans a .inc file named like the child test case.
	 *
	 * @since 0.1.0
	 */
	public function test() {

		$class = get_class( $this );
		$class = substr( $class, 40 /* WP_Deprecated_Code_Scanner\PHPUnit\Test\ */ );
		$file_name = $class . '.inc';

		$parser    = ( new ParserFactory )->create( ParserFactory::PREFER_PHP7 );
		$traverser = new NodeTraverser;

		$collector = new Collector;
		$traverser->addVisitor( new NodeVisitor( $collector, new Config ) );

		try {

			$code = file_get_contents( __DIR__ . '/../tests/' . $file_name );

			// parse
			$stmts = $parser->parse( $code );

			// traverse
			$traverser->traverse( $stmts );

			$found = $collector->get();

			$this->assertEquals( $this->expectations(), $found );

		} catch ( Error $e ) {
			echo 'Parse Error: ', $e->getMessage();
		}
	}

	/**
	 * Returns the list of deprecated elements expected to be found by the scanner.
	 *
	 * @since 0.1.0
	 *
	 * @return array[] The list of expected scan results.
	 */
	abstract public function expectations();
}

// EOF
