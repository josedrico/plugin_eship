<?php
/*
Plugin Name: WordPress Plugin E-Ship
Plugin URI:  https://github.com/jmlo2019/plugin_eship
Description: The skeleton for an object-oriented/MVC WordPress plugin
Version:     0.1a
Author:      Segmail
Author URI:  https://segmail.co/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ))) {
    //require plugin_dir_path( __FILE__ ) .  'plugin/bootstrap.php';
    if (is_admin()) {
        require __DIR__ . '/admin/load_admin.php';
    } else  {
        die();
    }
} else {
    exit;
}

