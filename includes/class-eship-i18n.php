<?php

/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
 *
 * @link       https://eship.com
 * @since     1.0.1
 *
 * @package    ESHIP
 * @subpackage ESHIP/includes
 */

/**
 * Class to language
 *
 * @since     1.0.1
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 */
class ESHIP_i18n {
    
    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since   1.0.1
     * @access public static
	 */    
    public function load_plugin_textdomain() {
        
        load_plugin_textdomain(
            'eship-textdomain',
            false,
            ESHIP_PLUGIN_DIR_PATH . 'languages'
        );
        
    }
    
}