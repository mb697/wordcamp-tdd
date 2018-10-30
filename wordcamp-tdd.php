<?php
/**
 * Plugin bootstrap file.
 *
 * @wordpress-plugin
 * Plugin Name: WordCamp Test Driven Development.
 * Version: 0.0.1
 * Author: Matt Bush
 *
 * @package wordcamp_tdd
 */

namespace wordcamp_tdd;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'TDD_ABSPATH', dirname( __FILE__ ) . '/' );
define( 'TDD_TEMPLATE_PATH', TDD_ABSPATH . 'templates/' );

// Autoloader.
require TDD_ABSPATH . 'lib/autoloader.php';

/**
 * Begins execution of the plugin.
 */
function run_plugin() {
	$plugin = new includes\Example_Two();
	add_action( 'plugins_loaded', [ $plugin, 'init' ], 2 );
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\run_plugin', 1 );
