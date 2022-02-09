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
        $this->defined_admin_hooks();
        
    }
    
    private function load_class()
    {

        /**
		 * Kernel load filters, actions and hooks
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-loader.php';

        /**
		 * Class to load language
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-i18n.php';        
        
        /**
		 * Class to build menupage
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-build-menupage.php';

        /**
         * Class add meta box
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-build-add-meta-box.php';

        /**
         * Class that defined alert messages
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-admin-notices.php';

        /**
         * Classes to work witdth API REST Woocommerce
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
         * Model to database
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-model.php';

        /**
         * Classes to consume API`s woocommerce and ESHIP
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-woocommerce-api.php';
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-api.php';

        /**
         * Resources to endpoints ESHIP API REST
         */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-quotation.php';
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-shipment.php';

        /**
		 * Class to defined logic plugin
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-admin.php'; 
        
    }
    
    private function set_language()
    {
        $eship_i18n = new ESHIP_i18n();
        $this->loader->add_action( 'plugins_loaded', $eship_i18n, 'load_plugin_textdomain' );
        
    }
    
    private function load_instances()
    {
        
        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->loader       = new ESHIP_Loader;
        $this->eship_admin  = new ESHIP_Admin( $this->get_plugin_name(), $this->get_version() );
        
    }
    
    private function defined_admin_hooks()
    {
        $this->loader->add_action( 'add_meta_boxes', $this->eship_admin, 'add_meta_boxes_eship' );
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $this->eship_admin, 'add_menu_order' );
        $this->loader->add_action( 'wp_ajax_get_quotation_data_eship', $this->eship_admin, 'get_quotation_data_eship' );
        $this->loader->add_action( 'wp_ajax_get_dimensions_eship', $this->eship_admin, 'get_dimensions_eship' );
        $this->loader->add_action( 'wp_ajax_insert_token_eship', $this->eship_admin, 'insert_token_eship' );
        $this->loader->add_action( 'wp_ajax_insert_dimensions_eship', $this->eship_admin, 'insert_dimensions_eship' );
        $this->loader->add_action( 'wp_ajax_update_token_eship', $this->eship_admin, 'update_token_eship' );
        $this->loader->add_action( 'wp_ajax_update_dimensions_eship', $this->eship_admin, 'update_dimensions_eship' );
        $this->loader->add_action( 'wp_ajax_get_quotation_eship', $this->eship_admin, 'get_quotation_eship' );
        $this->loader->add_action( 'wp_ajax_get_quotation_orders_eship', $this->eship_admin, 'get_quotation_orders_eship' );
        $this->loader->add_action( 'wp_ajax_get_shipment_eship', $this->eship_admin, 'get_shipment_eship' );
        $this->loader->add_action( 'wp_ajax_get_shipments_orders_eship', $this->eship_admin, 'get_shipments_orders_eship' );

        $this->loader->add_filter('bulk_actions-edit-shop_order', $this->eship_admin, 'insert_quotations_bulk_eship');
        $this->loader->add_filter('handle_bulk_actions-edit-shop_order', $this->eship_admin, 'get_quotations_bulk_eship');
        $this->loader->add_action( 'admin_head', $this->eship_admin, 'search_data_eship' );
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