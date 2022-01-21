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
            token_eship varchar(100) NOT NULL,
            consumer_key varchar(255) NOT NULL,
            consumer_secret varchar(255) NOT NULL,
            phone varchar(20) NOT NULL,
            name varchar(255) NOT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            PRIMARY KEY (id)
        );";

        $wpdb->query( $sql );
        
	}

}



