<?php
/**
 * The file that defines admin settings.
 *
 * @package wordcamp_tdd/includes.
 */

namespace wordcamp_tdd\includes;

/**
 * Admin Settings API.
 */
class Admin {

	/**
	 * Register a CF Zoho Settings page.
	 */
	public function settings_page() {

		add_options_page(
			'WordCamp TDD Options',
			'WordCamp TDD',
			'manage_options',
			'wordcamp_tdd',
			[ $this, 'wordcamp_tdd_settings_page_html' ]
		);
	}

	/**
	 *  Settings page.
	 */
	public function wordcamp_tdd_settings_page_html() {

		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Show error/update messages.
		settings_errors( 'wordcamp_tdd_messages' );

		// Template.
		include_once TDD_TEMPLATE_PATH . 'settings-form.php';
	}

	/**
	 * Inits the WP Settings API.
	 */
	public function settings_api_init() {

		// Register app details.
		add_settings_section(
			'wordcamp_tdd_section_developers',
			__( 'Expiry.', 'wordcamp_tdd' ),
			[ $this, 'wordcamp_tdd_settings_field_cb' ],
			'wordcamp_tdd'
		);
	}

	/**
	 * Settings field callback.
	 *
	 * @param array $args Settings arguments.
	 */
	public function wordcamp_tdd_settings_field_cb( $args ) {
        $month_years = $this->month_year();
		include_once TDD_TEMPLATE_PATH . 'settings-section.php';
    }
    
    /**
     * Returns an array of months and years starting with the current month for the next 12 months.
     *
     * @return array Next 12 months of month-year.
     * @internal test_that_months_and_years_are_correctly_returned.
     */
    public function month_year() {

        $date = new \DateTime();
        $out  = [];

        for( $n = 0; $n < 12; $n++ ) {
            $out[] = $date->format( 'm-Y' );
            $date->modify( "+1 months" );
        }

        return $out;
    }
}
