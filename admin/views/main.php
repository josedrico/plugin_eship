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
            'page_title'    => 'Tracking Guide',
            'menu_title'    => 'Tracking Guide',
            'capability'    => 'manage_options',
            'menu_slug'     => 'eship_tracking_guide',
            'function_name' => 'eShip_submenu_tracking_guide_page'
        ),
        array(
            'parent_slug'   => 'Eship',
            'page_title'    => 'Quote',
            'menu_title'    => 'Quote',
            'capability'    => 'manage_options',
            'menu_slug'     => 'eship_quote',
            'function_name' => 'eShip_submenu_quote_page'
        )
    );
    add_submenus_page($submenus);
}

function add_submenus_page($submenus)
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

function eShip_menu_page_display(){
    require_once dirname(__FILE__) . "/dashboard.php";
}

function eShip_submenu_configuration_page() {
    require_once dirname(__FILE__) . "/configuration.php";
}

function eShip_submenu_tracking_guide_page() {
    require_once dirname(__FILE__) . "/tracking_guide.php";
}

function eShip_submenu_quote_page() {
    require_once dirname(__FILE__) . "/quote.php";
}

add_action( 'admin_menu', 'eShip_menu_page' );
