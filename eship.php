<?php
/**
 * Archivo del plugin 
 * Este archivo es leído por WordPress para generar la información del plugin
 * en el área de administración del complemento. Este archivo también incluye 
 * todas las dependencias utilizadas por el complemento, registra las funciones 
 * de activación y desactivación y define una función que inicia el complemento.
 *
 * @link                https://eship.co
 * @since               1.0.0
 * @package             Eship Plugin
 *
 * @wordpress-plugin
 * Plugin Name:         Eship Plugin
 * Plugin URI:          https://eship.com
 * Description:         Crea una galería tipo portafolio y también toma valores de publicaciones a msotrar
 * Version:             1.0.0
 * Author:              SEGMAIL
 * Author URI:          https://segamail.com
 * License:             GPL2
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         eship-textdomain
 * Domain Path:         /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ESHIP_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'ESHIP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'ESHIP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * Código que se ejecuta en la activación del plugin
 */
function activate_eship() {
    require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-activator.php';
	ESHIP_Activator::activate();
}

/**
 * Código que se ejecuta en la desactivación del plugin
 */
function deactivate_eship() {
    require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-deactivator.php';
	ESHIP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_eship' );
register_deactivation_hook( __FILE__, 'deactivate_eship' );

require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-master.php';

function run_eship_master() {
    $eship_master = new ESHIP_Master;
    $eship_master->run();
}

run_eship_master();
























