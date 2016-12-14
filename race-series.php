<?php
/**
 * @link              http://trevan.co
 * @since             1.0.0
 * @package           Race_Series
 *
 * @wordpress-plugin
 * Plugin Name:       Race Series
 * Plugin URI:        http://hetzelcreative.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Trevan Hetzel
 * Author URI:        http://trevan.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       race-series
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Runs during plugin activation
function activate_race_series() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';
	Race_Series_Activator::activate();
}

// Runs during plugin deactivation
function deactivate_race_series() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
	Race_Series_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_race_series' );
register_deactivation_hook( __FILE__, 'deactivate_race_series' );

// Require main plugin class
require plugin_dir_path( __FILE__ ) . 'includes/race-series.php';

// Kick everything off
function run_race_series() {
	$plugin = new Race_Series();
	$plugin->run();
}

run_race_series();
