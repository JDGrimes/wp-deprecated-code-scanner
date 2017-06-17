<?php

/**
 * PHPUnit tests bootstrap.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

$loader = require __DIR__ . '/../../../vendor/autoload.php';
$loader->addPsr4( 'WP_Deprecated_Code_Scanner\PHPUnit\\', __DIR__ );

// EOF
