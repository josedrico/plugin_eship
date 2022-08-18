<?php
/**
 * ESHIP Plugin
 *
 * @package           EShipPackage
 * @author            https://myeship.co/
 * @copyright         2022 SEGMAIL
 * @license           GPLv3
 *
 * @wordpress-plugin
 * Plugin Name:       EShip
 * Plugin URI:        https://myeship.co/
 * Description:       Create and print shipping labels using preferential rates.
 * Version:           1.0.1
 * Requires at least: 5.6
 * Requires PHP:      7.2.5
 * Author:            SEGMAIL
 * Author URI:        https://segmail.co
 * Text Domain:       eship-slug
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
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
define( 'ESHIP_TB_DIM', "{$wpdb->prefix}eship_dimensions" );

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
} else {
    function wa_notice_error_eship() {
        $class = 'notice notice-error';
        $message = __( 'Don`t have woocommerce, it is necesary to ESHIP plugin!', 'sample-text.txt-domain' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    add_action( 'admin_notices', 'wa_notice_error_eship' );

}