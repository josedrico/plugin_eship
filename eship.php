<?php
/**
 * ESHIP Plugin
 *
 * @package           EShipPackage
 * @author            SEGMAIL
 * @copyright         2021 SEGMAIL
 * @license           MIT
 *
 * @wordpress-plugin
 * Plugin Name:       EShip
 * Plugin URI:        https://eship.com
 * Description:       Plugin to run wordpress and woocommerce.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            SEGMAIL
 * Author URI:        https://segmail.co
 * Text Domain:       eship-slug
 * License:           MIT
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://eship.com
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Routes to plugin
 */
global $wpdb;
define( 'ESHIP_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'ESHIP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'ESHIP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'ESHIP_TB', "{$wpdb->prefix}eship_data" );

/**
 * Activate EShip
 */
function activate_eship() {
    require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-activator.php';
	ESHIP_Activator::activate();
}

/**
 * Deactivate EShip
 */
function deactivate_eship() {
    require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-deactivator.php';
	ESHIP_Deactivator::deactivate();
}

/**
 * Register hook at activation and deactivation
 */
register_activation_hook( __FILE__, 'activate_eship' );
register_deactivation_hook( __FILE__, 'deactivate_eship' );

/**
 * Load file at run plugin
 */
require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-master.php';

function run_eship_master() {
    $eship_master = new ESHIP_Master;
    $eship_master->run();
}

/*
 * Check that exist woocommerce
 * */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    run_eship_master();
}