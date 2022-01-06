<?php
/**
 * Clase que administra y controla las cargas de las demás clases
 *
 * @link       https://eship.com
 * @since      1.0.0
 *
 * @package    ESHIP
 * @subpackage ESHIP/includes
 */

/**
 *
 * @since      1.0.0
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 * 
 * @property object $loader
 * @property string $plugin_name
 * @property string $version
 */
class ESHIP_Master {
    
    protected $loader;
    
    protected $plugin_name;
    
    protected $version;
    
    public function __construct() {
        
        $this->plugin_name = 'ESHIP';
        $this->version = '1.0.0';
        
        $this->load_class();
        $this->load_instances();
        $this->set_language();
        $this->definir_admin_hooks();
        
    }
    
    private function load_class() {
        
        /**
		 * La clase responsable de iterar las acciones y filtros del núcleo del plugin.
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-loader.php';
        
        /**
		 * La clase responsable de definir la funcionalidad de la
         * internacionalización del plugin
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-i18n.php';        
        
        /**
		 * La clase responsable de registrar menús y submenús
         * en el área de administración
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-build-menupage.php';
        
        
        /**
		 * La clase responsable de definir todas las acciones en el
         * área de administración
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-admin.php'; 
        
    }
    
    private function set_language() {
        
        //$eship_i18n = new ESHIP_i18n();
        //  $this->loader->add_action( 'plugins_loaded', $eship_i18n, 'load_plugin_textdomain' );        
        
    }
    
    private function load_instances() {
        
        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->loader       = new ESHIP_Loader;
        $this->eship_admin  = new ESHIP_Admin( $this->get_plugin_name(), $this->get_version() );
        
    }
    
    private function definir_admin_hooks() {
        
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_scripts' );
        
        $this->loader->add_action( 'admin_menu', $this->eship_admin, 'add_menu' );
        $this->loader->add_action( 'wp_ajax_insert_token_eship', $this->eship_admin, 'insert_token_eship' );
        $this->loader->add_action( 'wp_ajax_get_wc_orders_eship', $this->eship_admin, 'get_wc_orders_eship' );

    }
    
    public function run() {
        $this->loader->run();
    }
    
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_load() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}
    
}