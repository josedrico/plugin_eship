<?php
/**
 * Desinstala el plugin
 *
 * @link       https://eship.com
 * @since     1.0.1
 *
 * @package    ESHIP_blank
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 * Deleted table
 * */
global $wpdb;
$sql = "DROP TABLE IF EXISTS {$wpdb->prefix}eship_data";
$wpdb->query($wpdb->prepare($sql));

$sql_0 = "DROP TABLE IF EXISTS {$wpdb->prefix}eship_dimensions";
$wpdb->query($wpdb->prepare($sql_0));