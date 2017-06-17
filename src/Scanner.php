<?php

/**
 * Scanner class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Psr\Log\LoggerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Scanner that finds deprecated elements in a file or directory.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */
class Scanner {

	/**
	 * The parser used to parse the code.
	 *
	 * @since 0.1.0
	 *
	 * @var \PhpParser\Parser
	 */
	protected $parser;

	/**
	 * The traverser used to scan the code.
	 *
	 * @since 0.1.0
	 *
	 * @var \PhpParser\NodeTraverser
	 */
	protected $traverser;

	/**
	 * The collector used to hold the discovered deprecated elements.
	 *
	 * @since 0.1.0
	 *
	 * @var Collector
	 */
	protected $collector;

	/**
	 * The config for the scanner to tell it what to look for.
	 *
	 * @since 0.1.0
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * The logger used to supply feedback about the scan process.
	 *
	 * @since 0.1.0
	 *
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * @since 0.1.0
	 *
	 * @param Config          $config Scanner configuration.
	 * @param LoggerInterface $logger Logger to use to provide feedback.
	 */
	public function __construct( Config $config, LoggerInterface $logger  ) {

		$this->config = $config;
		$this->logger = $logger;
		$this->parser = ( new ParserFactory )->create( ParserFactory::PREFER_PHP7 );
		$this->traverser = new NodeTraverser;
		$this->collector = new Collector;

		// Add visitors.
		$this->traverser->addVisitor(
			new NodeVisitor( $this->collector, $this->config )
		);
	}

	/**
	 * Scans a file or directory.
	 *
	 * @since 0.1.0
	 *
	 * @param string $path The file or directory to scan.
	 *
	 * @return Collector The collection of discovered deprecated elements.
	 */
	public function scan( $path ) {

		if ( is_file( $path ) ) {
			$this->scan_file( $path );
		} else {
			$this->scan_directory( $path );
		}

		return $this->collector;
	}

	/**
	 * Scans a file for deprecated elements.
	 *
	 * @since 0.1.0
	 *
	 * @param string $file_name The full path of the file to scan.
	 */
	protected function scan_file( $file_name ) {

		try {

			$this->logger->info( 'Scanning ' . $file_name );

			$code = file_get_contents( $file_name );

			$this->traverser->traverse( $this->parser->parse( $code ) );

		} catch ( Error $e ) {

			$this->logger->error( 'Parse Error: ' . $e->getMessage() );
		}
	}

	/**
	 * Scans all .php files in a directory for deprecated elements.
	 *
	 * @since 0.1.0
	 *
	 * @param string $path The full path to the directory.
	 */
	protected function scan_directory( $path ) {

		$directory = new RecursiveDirectoryIterator(
			$path
			, RecursiveDirectoryIterator::SKIP_DOTS
		);

		$iterator = new RecursiveIteratorIterator( $directory );

		foreach( $iterator as $file ) {
			if ( substr( $file, -4 ) === '.php' ) {
				$this->scan_file( $file );
			}
		}
	}
}

// EOF
