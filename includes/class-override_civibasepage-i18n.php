<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link        http://aghstrategies.com/
 * @since      1.0.0
 *
 * @package    Override_civibasepage
 * @subpackage Override_civibasepage/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Override_civibasepage
 * @subpackage Override_civibasepage/includes
 * @author     Alice Frumin <alice@aghstrategies.com>
 */
class Override_civibasepage_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'override_civibasepage',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
