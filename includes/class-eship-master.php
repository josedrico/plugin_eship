<?php
/**
 * El archivo que define la clase del cerebro principal del plugin
 *
 * Una definición de clase que incluye atributos y funciones que se 
 * utilizan tanto del lado del público como del área de administración.
 * 
 * @link       https://eship.com
 * @since      1.0.0
 *
 * @package    ESHIP
 * @subpackage ESHIP/includes
 */

/**
 * También mantiene el identificador único de este complemento,
 * así como la versión actual del plugin.
 *
 * @since      1.0.0
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 * 
 * @property object $cargador
 * @property string $plugin_name
 * @property string $version
 */
class ESHIP_Master {
    
    protected $cargador;
    
    protected $plugin_name;
    
    protected $version;
    
    public function __construct() {
        
        $this->plugin_name = 'ESHIP';
        $this->version = '1.0.0';
        
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->set_idiomas();
        $this->definir_admin_hooks();
        
    }
    
    private function cargar_dependencias() {
        
        /**
		 * La clase responsable de iterar las acciones y filtros del núcleo del plugin.
		 */
        require_once ESHIP_PLUGIN_DIR_PATH . 'includes/class-eship-cargador.php';
        
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
    
    private function set_idiomas() {
        
        //$eship_i18n = new ESHIP_i18n();
        //  $this->cargador->add_action( 'plugins_loaded', $eship_i18n, 'load_plugin_textdomain' );        
        
    }
    
    private function cargar_instancias() {
        
        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->cargador     = new ESHIP_cargador;
        $this->eship_admin   = new ESHIP_Admin( $this->get_plugin_name(), $this->get_version() );
        
    }
    
    private function definir_admin_hooks() {
        
        $this->cargador->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_styles' );
        $this->cargador->add_action( 'admin_enqueue_scripts', $this->eship_admin, 'enqueue_scripts' );
        
        $this->cargador->add_action( 'admin_menu', $this->eship_admin, 'add_menu' );
        
    }
    
    public function run() {
        $this->cargador->run();
    }
    
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_cargador() {
		return $this->cargador;
	}

	public function get_version() {
		return $this->version;
	}
    
}