<?php

/**
 * WPCS formatter class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\Formatter;

use WP_Deprecated_Code_Scanner\Collector;

/**
 * Formats output to compare with WPCS sniff.
 *
 * @package WP_Deprecated_Code_Scanner\Formatter
 * @since   0.1.0
 */
class WPCS implements Formatter {

	/**
	 * @since 0.1.0
	 */
	public function format( Collector $collector ) {

		$output = "\tprivate \$deprecated_functions = array(\n";

		$results = [];

		$types = $collector->get();

		foreach ( $types['function'] as $item ) {
			$results[ $item['version'] ][ strtolower( $item['element'] ) ] = $item;
		}

		ksort( $results );

		foreach ( $results as $version => $functions ) {

			$output .= "\n\t\t// {$version}\n";

			ksort( $functions );

			foreach ( $functions as $function => $data ) {

				if ( $data['alt'] ) {
					$data['alt'] = str_replace( "'", "\\'", $data['alt'] );
				}

				$output .= "		'{$function}' => array(
			'alt'     => '{$data['alt']}',
			'version' => '{$version}',
		),\n";
			}
		}

		$output .= "\t);\n";

		return $output;
	}
}

// EOF
