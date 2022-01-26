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
    
    public function __construct()
    {
        
        $this->plugin_name = 'ESHIP';
        $this->version = '1.0.0';
        
        $this->load_class();
        $this->load_instances();
        $this->set_language();
        $this->definir_admin_hooks();
        
    }
    
    private function load_class()
    {

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
         * Clase de add meta box
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-build-add-meta-box.php';
        
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-admin-notices.php';

        /**
         * La clase responsable del woocommerce api
         * área de administración
         */
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/BasicAuth.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/OAuth.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Options.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Request.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Response.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClientException.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClient.php";
        require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/Client.php";

        /**
         * Consulta a base de datos
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-model.php';

        /**
         * Conexiones y configuraciones de las a
         * API
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-woocommerce-api.php';
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-api.php';

        /**
         * Configuraciones para consultas API´s
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-quotation.php';
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-shipment.php';

        /**
		 * La clase responsable de definir todas las acciones en el
         * área de administración
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-admin.php'; 
        
    }
    
    private function set_language()
    {
        
        //$eship_i18n = new ESHIP_i18n();
        //  $this->loader->add_action( 'plugins_loaded', $eship_i18n, 'load_plugin_textdomain' );        
        
    }
    
    private function load_instances()
    {
        
        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->loader       = new ESHIP_Loader;
        $this->eship_admin  = new ESHIP_Admin( $this->get_plugin_name(), $this->get_version() );
        
    }
    
    private function definir_admin_hooks()
    {
        $this->loader->add_action( 'add_meta_boxes', $this->eship_admin, 'add_meta_boxes_eship' );
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_ajax_get_quotation_data_eship', $this->eship_admin, 'get_quotation_data_eship' );
        $this->loader->add_action( 'wp_ajax_insert_token_eship', $this->eship_admin, 'insert_token_eship' );
        $this->loader->add_action( 'wp_ajax_update_token_eship', $this->eship_admin, 'update_token_eship' );
        $this->loader->add_action( 'wp_ajax_get_shipment_eship', $this->eship_admin, 'get_shipment_eship' );
        $this->loader->add_action( 'wp_ajax_get_quotation_eship', $this->eship_admin, 'get_quotation_eship' );
    }
    
    public function run()
    {
        $this->loader->run();
    }
    
	public function get_plugin_name()
    {
		return $this->plugin_name;
	}

	public function get_load()
    {
		return $this->loader;
	}

	public function get_version()
    {
		return $this->version;
	}
    
}