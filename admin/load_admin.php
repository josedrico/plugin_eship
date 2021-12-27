<?php
require_once __DIR__ . "/EshipAdmin.php";
use Eship\Admin\EshipAdmin as Admin;

if (! class_exists('EshipAdmin')) {
    $adm = new \Eship\Admin\EshipAdmin();
    var_dump($adm);
}