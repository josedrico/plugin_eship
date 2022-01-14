    <?php
    require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-quotation.php';
    use EshipAdmin\ESHIP_Quotation;

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
        private $db;
        private $eship_quotation;

        public function __construct( $plugin_name, $version ) 
        {
            global $wpdb;
            $this->db               = $wpdb;
            $this->plugin_name      = $plugin_name;
            $this->version          = $version;
            $this->eship_quotation  = new ESHIP_Quotation();
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
            wp_enqueue_style( 'eship_bootstrap_css', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap/css/bootstrap.min.css', array(), '5.1.3', '' );

            wp_enqueue_style( 'eship_fontawesome_free_css', ESHIP_PLUGIN_DIR_URL . 'helpers/fontawesome-free-5.15.4-web/css/all.min.css', array(), '5.15.4', '' );

            wp_enqueue_style( 'eship_bootstrap_table_admin_css', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap-table/css/bootstrap-table.min.css', array(), '1.19.1', '' );


            /**
             * eship-admin.css
             * Archivo de hojas de estilos principales
             * de la administración
             */
            wp_enqueue_style( $this->plugin_name, ESHIP_PLUGIN_DIR_URL . 'admin/css/eship-admin.css', array(), $this->version, '' );
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
            wp_enqueue_script( 'eship_bootstrap_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap/js/bootstrap.min.js', array(), '5.1.3', TRUE );

            wp_enqueue_script( 'eship_fontawesome_free_js', ESHIP_PLUGIN_DIR_URL . 'helpers/fontawesome-free-5.15.4-web/js/all.min.js', array(), '5.15.3', TRUE );

            /**
             * Extension Bootstrap Table
             * https://bootstrap-table.com/
             * Bootstrap Table
             */
            wp_enqueue_script( 'eship_bootstrap_table_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/bootstrap-table/js/bootstrap-table.min.js', array(), '1.19.1', TRUE );

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

        public function add_metabox_eship(){
            if (empty($this->get_token_eship())) {
                $register_view = [$this, 'view_register_eship'];
                $register_title = "<img src='" .ESHIP_PLUGIN_DIR_URL . 'admin/img/eship.png' . "' class='w-30 h-30'>";
            }  else {
                $register_view = [$this, 'view_buttons_eship'];
                $register_title = "<img class='img-thumbnail' style='width:80%;' src='" .ESHIP_PLUGIN_DIR_URL . 'admin/img/eship.png' . "'>";
            }

            add_meta_box(
                'woocommerce-order-eship',
                __($register_title, 'woocommerce'),
                $register_view,
                'shop_order',
                'side',
                'high'
            );
        }

        public function view_buttons_eship()
        {
            $result = FALSE;
            if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
                $result = $this->eship_quotation->create($_GET['post']);
            }

            $modal_custom = ESHIP_PLUGIN_DIR_PATH . 'admin/partials/buttons_modals/modal_custom.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/buttons_modals/buttons.php';
        }

        private function view_register_eship()
        {
            return ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/connection.php';
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

        private function get_token_eship()
        {
            $results = $this->db->get_results( "SELECT * FROM " . ESHIP_TB . ";", OBJECT );
            if ((count($results) > 0) && (isset($results[0]->token_eship)) && (! is_null($results[0]->token_eship))) {
                return $results[0]->token_eship;
            } else  {
                return '';
            }
        }
    }

