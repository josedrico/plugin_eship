<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       https://beziercode.com.co
 * @since      1.0.0
 *
 * @package    BCPortfolioGallery
 * @subpackage BCPortfolioGallery/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 */
class ESHIP_Activator {

	public static function activate() 
    {
        global $wpdb;

        $sql = "CREATE TABLE IF NOT EXISTS " . ESHIP_TB . "(
            id int(11) NOT NULL AUTO_INCREMENT,
            email varchar(255) NOT NULL,
            api_key_eship varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            name varchar(255) NOT NULL,
            dimensions smallint(1) NOT NULL,
            ck varchar(255),
            cs varchar(255),
            PRIMARY KEY (id)
        );";

        $wpdb->query( $sql );

        $sql_dim = "CREATE TABLE IF NOT EXISTS " . ESHIP_TB_DIM . "(
            id int(11) NOT NULL AUTO_INCREMENT,
            length_dim decimal(5,2) NOT NULL,
            width_dim decimal(5,2) NOT NULL,
            height_dim decimal(5,2) NOT NULL,
            unit_dim varchar(50) NOT NULL,
            weight_w decimal(5,2) NOT NULL,
            unit_w varchar(50) NOT NULL,
            status smallint(1) NOT NULL,
            name varchar(255) NOT NULL,
            created_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        );";

        $wpdb->query( $sql_dim );
        
	}

}



