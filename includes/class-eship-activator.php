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
            data longtext,
            PRIMARY KEY (id)
        );";

        $wpdb->query( $sql );
        
	}

}



