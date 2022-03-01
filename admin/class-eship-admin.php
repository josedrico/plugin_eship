<?php
    use EshipAdmin\ESHIP_Quotation;
    use EshipAdmin\ESHIP_Shipment;
    use EshipAdmin\ESHIP_Model;
    use EshipAdmin\ESHIP_Woocommerce_Api;
    use EshipAdmin\ESHIP_Api;
    use EshipAdmin\ESHIP_Admin_Notices;

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
        private $eship_quotation;
        private $eship_model;
        private $build_menupage;
        private $api_key_eship;

        public function __construct( $plugin_name, $version ) 
        {
            $this->plugin_name      = $plugin_name;
            $this->version          = $version;
            $this->eship_quotation  = new ESHIP_Quotation();
            $this->eship_model      = new ESHIP_Model();
            $this->build_menupage   = new ESHIP_Build_Menupage();
            $this->api_key_eship    = new ESHIP_Api();
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

            /**
             * Framework Fontawesome
             * https://fontawesome.com/
             * Fontawesome
             */
            wp_enqueue_style( 'eship_fontawesome_free_css', ESHIP_PLUGIN_DIR_URL . 'helpers/fontawesome-free-5.15.4-web/css/all.min.css', array(), '5.15.4', '' );

            /**
             * Library Bootstrap Table
             * https://bootstrap-table.com/
             * Fontawesome
             */
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

            wp_enqueue_script( 'eship_validation_jquery_admin_js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), 'v1.19.3', TRUE );
            wp_enqueue_script( 'eship_validation_jquery_methods_admin_js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js', array('jquery'), 'v1.19.3', TRUE );
            wp_enqueue_script( 'eship_sweetalert_js', ESHIP_PLUGIN_DIR_URL . 'helpers/sweetalert/sweetalert.min.js', array(), 'v2.0', TRUE );

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

        public function add_menu_order() {

            $this->build_menupage->add_menu_page(
                'ESHIP',
                'eShip',
                'manage_options',
                'eship_dashboard',
                [ $this, 'eship_dashboard' ],
                'none',
                25
            );

            $this->build_menupage->run();
        }

        public function eship_dashboard()
        {
            $config_data = array();
            $text_api_key = 'To obtain your API key, login into your eShip account <a href="https://app.myeship.co/" target="_blank">(app.myeship.co)</a>, go to "Settings" and click on "See your API Key';
            $dimensions = $this->eship_model->get_dimensions_eship();
            //var_dump($dimensions[0]);
            if ($user_eship = $this->eship_model->get_data_user_eship()) {
                $config_data = array(
                    'btn' => 'updateDataEshipModalBtn',
                    'form' => 'updateDataEshipModalForm',
                );
            } else {
                $config_data = array(
                    'btn'   => 'tokenEshipModalBtn',
                    'form'  => 'tokenEshipModalForm',
                );
            }

            $img_title = ESHIP_PLUGIN_DIR_URL . 'admin/img/eship.png';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/dashboard_connection.php';
        }

        public function insert_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            $exist_api_key = $this->api_key_eship->getCredentials($_POST['token']);
            if ($exist_api_key) {
                if (! isset($exist_api_key['body'])) {
                    $this->response(
                        array(
                                'result'    => NULL,
                                'test'      => $exist_api_key,
                                'show'      => FALSE,
                                'message'   => 'Failed to establish connection with eShip.',
                                'error'     => TRUE,
                                'code'      => 500
                            ),
                        TRUE
                    );
                } else {

                    if (!$this->eship_model->get_data_user_eship('token')) {
                        $api_eship = json_decode($exist_api_key['body']);
                    } else {
                        $api_eship = FALSE;
                    }


                    if (isset($api_eship->error)) {
                        if ($api_eship->error == 'API Key authentication failed.') {
                            $message = 'Your eShip api key is wrong. Please follow the instructions to connect your eShip account to this WooCommerce Store';
                        } else  {
                            $message = $api_eship->error;
                        }

                        $this->response(
                            array(
                                'result'    => NULL,
                                'test'      => $exist_api_key,
                                'show'      => FALSE,
                                'message'   => $message,
                                'error'     => TRUE,
                                'code'      => 404
                            ),
                            TRUE
                        );
                    } else {
                        if (empty($api_eship->consumer_secret)) {
                            $message = 'Please follow the instructions to connect your eShip account to this WooCommerce Store';
                        } else  {
                            $insert_db = $this->eship_model->insert_data_store_eship($_POST);
                            $message = 'Fail to insert data on table';
                        }

                        if ($insert_db) {

                            $this->response(
                                array(
                                    'result'    => NULL,
                                    'test'      => $api_eship,
                                    'show'      => FALSE,
                                    'message'   => 'Your service is connnect.',
                                    'error'     => FALSE,
                                    'code'      => 200
                                ),
                                TRUE
                            );
                        } else {
                            $this->response(
                                array(
                                    'result'    => NULL,
                                    'test'      => $exist_api_key,
                                    'show'      => FALSE,
                                    'message'   => $message,
                                    'error'     => TRUE,
                                    'code'      => 500
                                ),
                                TRUE
                            );
                        }
                    }
                }

            } else  {
                $response = array(
                    'message'       => 'Api Key is neccesary',
                    'result'        => FALSE,
                    'error'         => TRUE,
                    'updateEffect'  => TRUE,
                    'code'          => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }

        public function update_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result     = $this->eship_model->update_data_store_eship($_POST);
            $response   = array();
            if ($_POST['typeAction'] == 'update_token') {
                if ($result) {
                    $response = array(
                        'result'    => 'Done!',
                        'redirect'  => TRUE,
                        'error'     => FALSE,
                        'code'      => 201
                    );
                } else  {
                    $response = array(
                        'result'    => 'No updated',
                        'error'     => TRUE,
                        'code'      => 404
                    );
                }
            }

            /*
             * Check if exist a config on table
             * */
            $check_dim = $this->eship_model->get_dimensions_eship();
            if($check_dim) {
                if ($_POST['typeAction'] == 'update_status_dimension') {
                    $id_token    = $this->eship_model->get_data_user_eship('id');

                    if ($_POST['status'] == 'default') {
                        $dim_token = 1;
                    } else if ($_POST['status'] == 'template') {
                        $dim_token = 0;
                    }

                    $result = $this->eship_model->update_data_store_eship(array(
                        'id'         => $id_token,
                        'dimensions' => $dim_token,
                        'typeAction' => 'update_dimension_token'
                    ));

                    if ($result) {
                        $response = array(
                            'result'    => 'Done!',
                            'res'       => $result,//$dim_content,
                            //'post'       => $_POST,
                            //'dim_content'  => $dim_content,
                            'message'   => 'Your data is update',
                            'updateEffect' => $result,
                            'error'     => FALSE,
                            'code'      => 201
                        );
                    } else  {
                        $response = array(
                            'result'    => 'No updated',
                            'res'       => $result,
                            'message'   => 'Your data not is update',
                            'error'     => TRUE,
                            'code'      => 404
                        );
                    }
                }
            } else {
                $response = array(
                    'result'  => array(
                        'resource' => 'eshipDimWeModal'
                    ),
                    'message' => 'Your dimensions of your packages are not configured, please create your dimensions',
                    'error'   => TRUE,
                    'code'    => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }

        private function response($data, $test = FALSE)
        {
            if ($test) {
                $response =  array(
                    'result'    => $data['result'],
                    'test'      => $data['test'],
                    'show'      => $data['show'],
                    'message'   => $data['message'],
                    'error'     => $data['error'],
                    'code'      => $data['code']
                );
            } else {
                $response =  array(
                    'result'    => $data['result'],
                    'show'      => $data['show'],
                    'message'   => $data['message'],
                    'error'     => $data['error'],
                    'code'      => $data['code']
                );
            }


            echo json_encode($response);
            wp_die();
        }
    }

