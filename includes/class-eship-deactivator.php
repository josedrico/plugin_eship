<?php
/**
 * Ésta clase define todo lo necesario durante la desactivación del plugin
 *
 * @since      1.0.0
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 */

class ESHIP_Deactivator {

	public static function deactivate() 
    {
        flush_rewrite_rules();
        
	}

}