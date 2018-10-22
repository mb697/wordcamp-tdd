<?php
/**
 * The file that defines the core plugin class.
 *
 * @package wordcamp_tdd/includes.
 */

namespace wordcamp_tdd\includes;

/**
 * Main Wordcamp_Tdd Class.
 */
final class Wordcamp_Tdd {

	/**
	 * Init the plugin.
	 */
	public function init() {

        // Actions and Filters.
		$admin = new Admin();

		add_action( 'admin_menu', [ $admin, 'settings_page' ] );
		add_action( 'admin_init', [ $admin, 'settings_api_init' ] );
	}
}
