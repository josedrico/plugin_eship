    <?php

    /**
     * La funcionalidad específica de administración del plugin.
     *
     * @link       https://eship.com
     * @since      1.0.0
     *
     * @package    ESHIP_blank
     * @subpackage ESHIP_blank/admin
     */

    /**
     * Define el nombre del plugin, la versión y dos métodos para
     * Encolar la hoja de estilos específica de administración y JavaScript.
     * 
     * @since      1.0.0
     * @package    ESHIP
     * @subpackage ESHIP/admin
     * @author     Juan Manuel Leal <jleal@segmail.co>
     * 
     * @property string $plugin_name
     * @property string $version
     */
    class ESHIP_Admin {
        
        private $plugin_name;
        
        private $version;
        
        private $build_menupage;
        

        public function __construct( $plugin_name, $version ) 
        {
            
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            $this->build_menupage = new ESHIP_Build_Menupage();
            
        }

        public function enqueue_styles($hook) 
        {
            //toplevel_page_toplevel_page_ 
            if( $hook ) {
                $hook;
            }
            /**
             * Framework Bootstrap
             * https://getbootstrap.com/
             * Bootstrap
             */
            wp_enqueue_style( 'eship_bootstrap_css', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap/css/bootstrap.min.css', array(), '5.1.3', 'all' );

            /**
             * eship-admin.css
             * Archivo de hojas de estilos principales
             * de la administración
             */
            wp_enqueue_style( 'eship_bootstrap_table_admin_css', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap-table/css/bootstrap-table.min.css', array(), '1.19.1', 'all' );
            
            wp_enqueue_style( $this->plugin_name, ESHIP_PLUGIN_DIR_URL . 'admin/css/eship-admin.css', array(), $this->version, 'all' );
        }
        
        public function enqueue_scripts($hook) 
        {
            if( $hook ) {
                $hook;
            } 

            /**
             * Framework Bootstrap
             * https://getbootstrap.com/
             * Bootstrap
             */
            wp_enqueue_script( 'eship_bootstrap_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap/js/bootstrap.min.js', array(), '5.1.3', true );

            /**
             * Extension Bootstrap Table
             * https://bootstrap-table.com/
             * Bootstrap Table
             */
            wp_enqueue_script( 'eship_bootstrap_table_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap-table/js/bootstrap-table.min.js', array(), '1.19.1', true );

            wp_enqueue_script( 'eship_admin_js', ESHIP_PLUGIN_DIR_URL . 'admin/js/eship-admin.js', array(), $this->version, true );
            
        }
        
        public function add_menu() {
            
            $this->build_menupage->add_menu_page(
                'Dashboard',//__( 'ESHIP', 'eship-textdomain' ),
                'eship',//__( 'ESHIP', 'eship-textdomain' ),
                'manage_options',
                'eship_dashboard',
                [ $this, 'controlador_display_menu' ],
                '',
                65
            );

            $this->build_menupage->add_submenu_page(
                'eship_dashboard',
                'Quotes',
                'quotes',
                'manage_options',
                'eship_quotes',
                [ $this, 'controlador_display_submenu_quotes' ]
            );

            $this->build_menupage->add_submenu_page(
                'eship_dashboard',
                'configuration',
                'configuration',
                'manage_options',
                'eship_configuration',
                [ $this, 'controlador_display_submenu_configuration' ]
            );

            $this->build_menupage->add_submenu_page(
                'eship_dashboard',
                'Tracking Guide',
                'tracking guide',
                'manage_options',
                'eship_tracking_guide',
                [ $this, 'controlador_display_submenu_tracking_guide' ]
            );
            $this->build_menupage->run();
        }

        public function controlador_display_menu() 
        {
            //https://woocommerce.github.io/woocommerce-rest-api-docs/#introduction
            $wc_img = ESHIP_PLUGIN_DIR_URL . 'admin/img/woocommerce.png';
            $menu_header = ESHIP_PLUGIN_DIR_URL . 'admin/img/eshipw.png';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/dashboard/eship-dashboard.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
        }

        public function controlador_display_submenu_quotes() 
        {
            $wc_img = ESHIP_PLUGIN_DIR_URL . 'admin/img/woocommerce.png';
            $menu_header = ESHIP_PLUGIN_DIR_URL . 'admin/img/eshipw.png';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/quotes/quotes.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
        }

        public function controlador_display_submenu_configuration() 
        {
            $wc_img = ESHIP_PLUGIN_DIR_URL . 'admin/img/woocommerce.png';
            $menu_header = ESHIP_PLUGIN_DIR_URL . 'admin/img/eshipw.png';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/configuration/configuration.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
        }

        public function controlador_display_submenu_tracking_guide() 
        {
            $wc_img = ESHIP_PLUGIN_DIR_URL . 'admin/img/woocommerce.png';
            $menu_header = ESHIP_PLUGIN_DIR_URL . 'admin/img/eshipw.png';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/tracking_guide/tracking_guide.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
        }
    }

