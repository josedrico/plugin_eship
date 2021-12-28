<?php

function eShip_menu_page() {
    add_menu_page(
        'Eship',
        'Eship',
        'manage_options',
        'Eship',
        'eShip_menu_page_display',
        dirname(dirname(plugin_dir_path( __FILE__ ))) . "/public/image/icon/icon.favicon",
        30
    );

    $submenus = array(
        array(
            'parent_slug'   => 'Eship',
            'page_title'    => 'Configuration',
            'menu_title'    => 'Configuration',
            'capability'    => 'manage_options',
            'menu_slug'     => 'eship_configuration',
            'function_name' => 'eShip_submenu_configuration_page'
        ),
        array(
            'parent_slug'   => 'Eship',
            'page_title'    => 'Guías',
            'menu_title'    => 'Guias',
            'capability'    => 'manage_options',
            'menu_slug'     => 'eship_guias',
            'function_name' => 'eShip_submenu_guide_page'
        ),
        array(
            'parent_slug'   => 'Eship',
            'page_title'    => 'Catización',
            'menu_title'    => 'Cotización',
            'capability'    => 'manage_options',
            'menu_slug'     => 'eship_cotizacion',
            'function_name' => 'eShip_submenu_cotizacion_page'
        ),
    );

    addSubmenusPage($submenus);
}

function eShip_menu_page_display(){
    require_once dirname(__FILE__) . "/index.php";
}

function addSubmenusPage($submenus)
{
    if (is_array($submenus)) {
        for ($i = 0; $i < count($submenus); $i++) {
            add_submenu_page(
                $submenus[$i]['parent_slug'],
                $submenus[$i]['page_title'],
                $submenus[$i]['menu_title'],
                $submenus[$i]['capability'],
                $submenus[$i]['menu_slug'],
                $submenus[$i]['function_name']
            );
        }
    }
}

function eShip_submenu_configuration_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    </div>
    <?php
}

function eShip_submenu_guide_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    </div>
    <?php
}

function eShip_submenu_cotizacion_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    </div>
    <?php
}

add_action( 'admin_menu', 'eShip_menu_page' );
