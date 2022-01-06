    <?php
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/BasicAuth.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/OAuth.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Options.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Request.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Response.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClientException.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClient.php";
    require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/Client.php";

    use Automattic\WooCommerce\Client;

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
        private $db;

        public function __construct( $plugin_name, $version ) 
        {
            global $wpdb;
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            $this->build_menupage = new ESHIP_Build_Menupage();
            $this->db = $wpdb;
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

            /**
             * Library Visualization  Graphs
             * https://echarts.apache.org/en/index.html
             * Apache ECharts
             */
            wp_enqueue_script( 'eship_echart_admin_js', 'https://cdn.jsdelivr.net/npm/echarts@5.2.2/dist/echarts.js', array(), '', TRUE );


            wp_enqueue_script( $this->plugin_name, ESHIP_PLUGIN_DIR_URL . 'admin/js/eship-admin.js', array(), $this->version, TRUE );
            
            wp_localize_script(
                $this->plugin_name,
                'eshipData',
                array(
                    'url'      => admin_url('admin-ajax.php'),
                    'security' => wp_create_nonce('eship_sec')
                )
            );
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
            $wc_img         = ESHIP_PLUGIN_DIR_URL . 'admin/img/woocommerce.png';
            $menu_header    = ESHIP_PLUGIN_DIR_URL . 'admin/img/eshipw.png';

            if (empty($this->get_token_eship())) {
                /*$token_data = array(
                    'email'         => '',
                    'token_eship'   => '',
                    'data'          => ''
                );

                $insert_db  = $this->insert_token_eship($token_data);*/
                $menu_title = 'Connection';

                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/connection.php';
                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
            } else {
                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/navbar.php';
                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/dashboard/dashboard.php';
                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/templates/footer.php';
            } 
        }

        public function controlador_display_submenu_quotes() 
        {
            $list_orders = $this->woocommerce_conn_eship('list_orders');
            $new_list_orders = array();
            foreach ($list_orders as $key_orders) {
                //var_dump($key_orders);
                array_push($new_list_orders, array(
                    'id' => $key_orders->id,
                    'status' => $key_orders->status,
                    'currency' => $key_orders->currency,
                    'date_created' => $key_orders->date_created
                ));
                //die();
            }

            $json = json_encode($new_list_orders);
            $res_quotation = wp_remote_get( 'https://api.myeship.co/rest/quotation', array(
                'headers' => array(
                    'content-Type' => 'Application/json',
                    'api-key' => 'eship_prod_835261c341f8465b2'
                )
            ));

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

        private function get_token_eship()
        {
            $results = $this->db->get_results( "SELECT * FROM " . ESHIP_TB . ";", OBJECT );
            if ((count($results) > 0) && (isset($results[0]->token_eship)) && (! is_null($results[0]->token_eship))) {
                return $results[0]->token_eship;
            } else  {
                return '';
            }
        }

        public function insert_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $response = array();
            if(current_user_can('manage_options')) {
                $adm = wp_get_current_user();
                extract($_POST, EXTR_OVERWRITE);

                if($typeAction == 'add_token') {
                    $columns = [
                        'email'         => $adm->user_email,
                        'token_eship'   => $token,
                        'data'          => NULL,
                    ];
                    
                    $format = [
                        "%s",
                        "%s",
                        "%s"
                    ];
        
                    $result = $this->db->insert( ESHIP_TB, $columns, $format );
                    if ($result > 0) {
                        $response = array(
                            'result'    => 'Se inserto token',
                            'redirect'  => '?page=eship_dashboard',
                            'error'     => FALSE,
                            'code'      => 201
                        );
                    } else  {
                        $response = array(
                            'result'    => 'No se inserto tu token',
                            'redirect'  => '?page=eship_dashboard',
                            'error'     => TRUE,
                            'code'      => 404
                        );
                    }

                }

                echo json_encode($response);
                wp_die();
            }
            
        }


        public function woocommerce_conn_eship($type, $format = FALSE) {
            $woocommerce = new Client(
                'http://18.191.235.204/wp-plugin-eship',
                'ck_e1e2f573ca6d3237a02a7442952fa37806ef47ea',
                'cs_fc047f331954ffa83623ed0f47c927afee406438',
                [
                    'wp_api' => true,
                    'version' => 'wc/v3'
                ]
            );

            switch($type) {
                case 'list_orders':
                    return $woocommerce->get('orders');
                default:
                    return $woocommerce->get('');
            }
        }
    }

