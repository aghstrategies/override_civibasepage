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
	$ocb_settings = get_option('ocb_settings');
	$slugs = explode(',', $ocb_settings['ocb_text_field_0']);
	function trim_value(&$value) {
	  $value = trim($value);
	}
	$slugs = array_walk($slugs, 'trim_value');
	$templateChosen = $ocb_settings['ocb_text_field_1'];
	$pageSlug = basename(get_permalink());
	if (in_array($pageSlug, $slugs)) {
		return $templateChosen;
	}
	else {
		return $template;
	}
}

// Options page
add_action( 'admin_menu', 'ocb_add_admin_menu' );
add_action( 'admin_init', 'ocb_settings_init' );


function ocb_add_admin_menu(  ) {

	add_options_page( 'Override CiviBasePage', 'Override CiviBasePage', 'manage_options', 'override_civibasepage', 'ocb_options_page' );

}

function ocb_settings_init(  ) {

	register_setting( 'pluginPage', 'ocb_settings' );

	add_settings_section(
		'ocb_pluginPage_section',
		__( 'Settings for Override CiviBasePage', 'override_civibaspage' ),
		'ocb_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'ocb_text_field_0',
		__( 'Slug', 'override_civibaspage' ),
		'ocb_text_field_0_render',
		'pluginPage',
		'ocb_pluginPage_section'
	);

	add_settings_field(
		'ocb_text_field_1',
		__( 'Wordpress Template Page to be used', 'override_civibaspage' ),
		'ocb_text_field_1_render',
		'pluginPage',
		'ocb_pluginPage_section'
	);


}


function ocb_text_field_0_render(  ) {

	$options = get_option( 'ocb_settings' );
	?>
	<input type='text' name='ocb_settings[ocb_text_field_0]' value='<?php echo $options['ocb_text_field_0']; ?>'>
	<?php

}


function ocb_text_field_1_render(  ) {

	$options = get_option( 'ocb_settings' );
	?>
	<input type='text' name='ocb_settings[ocb_text_field_1]' value='<?php echo $options['ocb_text_field_1']; ?>'>
	<?php

}


function ocb_settings_section_callback(  ) {

	echo __( 'Enter the slugs to override the civibasepage on and the wordpress theme template to use below. For more information on this Wordpress Plugin visit: <a href="https://github.com/aghstrategies/override_civibasepage" >https://github.com/aghstrategies/override_civibasepage</a>', 'override_civibaspage' );

}


function ocb_options_page(  ) {

	?>
	<form action='options.php' method='post'>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php
}


run_override_civibasepage();
