<?php
require_once dirname(__DIR__) . "/includes/config-wc-api.php";
require_once dirname(__DIR__) . "/includes/config-eship-api.php";
require_once __DIR__ . "/Eship_admin.php";

use Automattic\WooCommerce\Client as Client;

use Eship\Admin\Eship_Admin;

if (! class_exists('Eship_admin')) {
    $admin = new \Eship\Admin\Eship_Admin();
    $admin->enqueue_styles('bootstrap_css', 'public/css/bootstrap.min.css','5.1.3');
    $admin->enqueue_styles('eship_css', 'public/css/eship.css','0.1a');
    $admin->enqueue_styles('bootstrap_table_css', 'public/css/bootstrap-table.min.css','1.19.1');
    $admin->enqueue_scripts('bootstrap_js', 'public/js/bootstrap.min.js','5.1.3');
    $admin->enqueue_scripts('bootstrap_table_js', 'public/js/bootstrap-table.min.js','1.19.1');
    $admin->enqueue_scripts('bootstrap_table_es_js', 'public/js/bootstrap-table-es-MX.min.js','1.19.1');

    require_once __DIR__ . "/views/main.php";

    $woocommerce = new Client(
        'http://example.com',
        'ck_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
        'cs_XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
        [
            'version' => 'wc/v3',
        ]
    );

}
