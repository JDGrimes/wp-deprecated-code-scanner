<?php

/**
 * Run console command class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use WP_Deprecated_Code_Scanner\Config;
use WP_Deprecated_Code_Scanner\Scanner;

/**
 * Handles the run console command.
 *
 * @package WP_Deprecated_Code_Scanner\Console
 * @since   0.1.0
 */
class Run extends Command {

	/**
	 * @since 0.1.0
	 */
	protected function configure() {

		$this
			->setName( 'run' )
			->setDescription( 'Run the scanner' )
			->addArgument(
				'path'
				, InputArgument::OPTIONAL
				, 'The file or directory to scan. Defaults to the current working directory'
			)
			->addOption(
				'bootstrap'
				, 'b'
				, InputOption::VALUE_REQUIRED
				, 'If set, the given bootstrap file will be loaded to supply custom configuration'
			)
		;
	}

	/**
	 * @since 0.1.0
	 */
	protected function execute( InputInterface $input, OutputInterface $output ) {

		$path = $input->getArgument( 'path' );

		if ( ! $path ) {
			$path = getcwd();
		}

		$config = new Config;
		$logger = new ConsoleLogger( $output );
		$scanner = new Scanner( $config, $logger );

		$collector = $scanner->scan( $path );

		$results = [];

		foreach ( $collector->get() as $item ) {
			$results[ $item['version'] ][ $item['element'] ] = $item;
		}

		ksort( $results );

		foreach ( $results as $version => $functions ) {

			$output->writeln( "## {$version}" );

			ksort( $functions );

			$functions = array_unique( $functions );

			foreach ( $functions as $function => $data ) {

				$message = "- `{$function}()`";

				if ( isset( $data['alt'] ) ) {
					$message .= " (use `{$data['alt']}()` instead)";
				}

				$output->writeln( $message );
			}

			$output->writeln( '' );
		}
	}
}

// EOF
