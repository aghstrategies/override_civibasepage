<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link               http://aghstrategies.com/
 * @since             1.0.0
 * @package           Override_civibasepage
 *
 * @wordpress-plugin
 * Plugin Name:       Override Civibasepage
 * Plugin URI:        http://github.com/aghstrategies/override_civibasepage
 * Description:       wordpress plugin to allow one to pick the template used for a civi frontend workflow
 * Version:           1.0.0
 * Author:            Alice Frumin
 * Author URI:        http://aghstrategies.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       override_civibasepage
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-override_civibasepage-activator.php
 */
function activate_override_civibasepage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-override_civibasepage-activator.php';
	Override_civibasepage_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-override_civibasepage-deactivator.php
 */
function deactivate_override_civibasepage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-override_civibasepage-deactivator.php';
	Override_civibasepage_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_override_civibasepage' );
register_deactivation_hook( __FILE__, 'deactivate_override_civibasepage' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-override_civibasepage.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_override_civibasepage() {

	$plugin = new Override_civibasepage();
	$plugin->run();
	add_filter('civicrm_basepage_template', 'oc_select_template');
}

// function override_civibasepage_func() {
// }
/**
 * [oc_select_template description]
 * @return [type] [description]
 */
function oc_select_template($template) {
	if (basename(get_permalink()) == 'iware') {
		return 'template-blank.php';
	}
	else {
		return $template;
	}
}

run_override_civibasepage();
