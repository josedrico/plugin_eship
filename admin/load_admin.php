<?php
require_once __DIR__ . "/Eship_admin.php";

use Eship\Admin\Eship_Admin;

if (! class_exists('Eship_admin')) {
    $admin = new \Eship\Admin\Eship_Admin();
    $admin->enqueue_styles('bootstrap_css', 'bootstrap.min.css','5.1.3');
    $admin-> enqueue_scripts('bootstrap_js', 'bootstrap.min.js','5.1.3');

    require_once __DIR__ . "/views/main.php";
}
