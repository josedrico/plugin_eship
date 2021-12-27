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

function eShip_output_test(){
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'wporg_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'wporg' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php

}

add_action( 'admin_menu', 'eShip_options_page' );
function eShip_options_page() {
    add_menu_page(
        'Eship',
        'Eship Options',
        'manage_options',
        'Eship',
        'eShip_output_test',
        plugin_dir_path( __FILE__ ),
        30
    );
}

