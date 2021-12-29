<?php
function eShip_menu_page() {
    $adm = new Eship\Admin\Eship_Admin();
    //var_dump($adm);
    add_menu_page(
        'Eship',
        'Eship',
        'manage_options',
        'Eship',
        'eShip_menu_page_display',
        '',//$adm->getIconMenu(),
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
    $adm = new Eship\Admin\Eship_Admin();
    $menu_header = $adm->getHeaderImg();
    $wc_img = $adm->getImgWoocommerce();
    require_once dirname(__FILE__) . "/partials/navbar.php";
    require_once dirname(__FILE__) . "/dashboard.php";
    require_once dirname(__FILE__) . "/partials/footer.php";
}

function eShip_submenu_configuration_page() {
    $adm = new Eship\Admin\Eship_Admin();
    $menu_header = $adm->getHeaderImg();
    $wc_img = $adm->getImgWoocommerce();
    require_once dirname(__FILE__) . "/partials/navbar.php";
    require_once dirname(__FILE__) . "/configuration.php";
    require_once dirname(__FILE__) . "/partials/footer.php";
}

function eShip_submenu_tracking_guide_page() {
    $adm = new Eship\Admin\Eship_Admin();
    $menu_header = $adm->getHeaderImg();
    $adm->enqueue_scripts('tracking_guide_js', 'admin/views/partials/tracking_guide/tracking-guide.js', '0.1a');
    require_once dirname(__FILE__) . "/partials/navbar.php";
    require_once dirname(__FILE__) . "/tracking_guide.php";
    require_once dirname(__FILE__) . "/partials/footer.php";
}

function eShip_submenu_quote_page() {
    $adm = new Eship\Admin\Eship_Admin();
    $menu_header = $adm->getHeaderImg();
    $adm->enqueue_scripts('quote_js', 'admin/views/partials/quote/quote.js', '0.1a');
    require_once dirname(__FILE__) . "/partials/navbar.php";
    require_once dirname(__FILE__) . "/quote.php";
    require_once dirname(__FILE__) . "/partials/footer.php";
}

add_action( 'admin_menu', 'eShip_menu_page' );
