<?php
    use EshipAdmin\ESHIP_Quotation;
    use EshipAdmin\ESHIP_Shipment;
    use EshipAdmin\ESHIP_Model;
    use EshipAdmin\ESHIP_Woocommerce_Api;
    use EshipAdmin\ESHIP_Api;
    use EshipAdmin\ESHIP_Admin_Notices;

    /**
     * Defines the plugin name, version and two methods for enqueue the admin-specific style sheet and JavaScript.
     * 
     * @since      1.0.0
     * @package    ESHIP
     * @author     juanmaleal
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
            $this->plugin_name     = $plugin_name;
            $this->version         = $version;
            $this->eship_quotation = new ESHIP_Quotation();
            $this->eship_model     = new ESHIP_Model();
            $this->build_menupage  = new ESHIP_Build_Menupage();
            $this->api_key_eship   = new ESHIP_Api();
        }

        /*
         * Admin Styles
         * */
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

        /*
         * Scripts JS
         * */
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

            wp_enqueue_script( 'eship_validation_jquery_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/jqueryvalidation/jquery.validate.min.js', array(), 'v1.19.3', TRUE );
            wp_enqueue_script( 'eship_validation_jquery_methods_admin_js', ESHIP_PLUGIN_DIR_URL . 'helpers/jqueryvalidation/additional-methods.min.js', array(), 'v1.19.3', TRUE );
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

        /*
         * Menu Adminstration
         * */
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

        /*
         * Register  and active account eship
         * */
        public function eship_dashboard()
        {
            $config_data     = array();
            $instructions_ak = TRUE;
            $dimensions      = $this->eship_model->get_dimensions_eship();

            if ($user_eship = $this->eship_model->get_data_user_eship()) {
                $config_data = array(
                    'btn'  => 'updateDataEshipModalBtn',
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

        /*
         * Insert api key of eship account on table
         * */
        public function insert_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            $exist_api_key = $this->api_key_eship->getCredentials(sanitize_text_field($_POST['token']));
            if ($exist_api_key) {
                if (! isset($exist_api_key['body'])) {
                    $this->response(
                        array(
                                'result'  => NULL,
                                'test'    => $exist_api_key,
                                'show'    => FALSE,
                                'message' => 'Failed to establish connection with eShip.',
                                'error'   => TRUE,
                                'code'    => 500
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
                            $message    = 'Your API key is incorrect, please check again.';
                            $msg_text   = 'To obtain your API key, you must log in to eShip, go to Settings and click on “See your API Key”. Important! It\'s necessary to be subscribed to a paid plan to access this service.';
                            $html       = "<a href='https://myeship.co/#pricing'>Click here.</a>";
                        } else  {
                            $message    = $api_eship->error;
                            $msg_text   = '';
                            $html       = '';
                        }

                        $this->response(
                            array(
                                'result'  => NULL,
                                'test'    => $exist_api_key,
                                'show'    => FALSE,
                                'message' => $message,
                                'msgText' => $msg_text,
                                'html'    => $html,
                                'error'   => TRUE,
                                'code'    => 404
                            ),
                            TRUE
                        );
                    } else {
                        if (empty($api_eship->consumer_secret) || empty($api_eship->consumer_key)) {
                            $eship_user= TRUE;
                            $message = 'Your eShip account is not connected to any Woocommerce store. Please enter your customer secret and customer key with read/write permissions.';
                        }

                        if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                            $type_action = sanitize_text_field($_POST['typeAction']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'typeAction!. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['token']) && !empty($_POST['token'])) {
                            $token = sanitize_text_field($_POST['token']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'token!. This data cannot be empty.',
                                    'error'   => FALSE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['name']) && !empty($_POST['name'])) {
                            $name = sanitize_text_field($_POST['name']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Phone!. This data cannot be empty.',
                                    'error'   => FALSE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                            $phone = sanitize_text_field($_POST['phone']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Phone!. This data cannot be empty.',
                                    'error'   => FALSE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['email']) && !empty($_POST['email'])) {
                            $email = sanitize_email($_POST['email']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Phone!. This data cannot be empty.',
                                    'error'   => FALSE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['dimensions']) && !empty($_POST['dimensions'])) {
                            $dimensions = sanitize_text_field($_POST['dimensions']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Phone!. This data cannot be empty.',
                                    'error'   => FALSE,
                                    'code'    => 404
                                )
                            );
                        }

                        $consumer_key    = (isset($api_eship->consumer_key) && ! empty($api_eship->consumer_key))? $api_eship->consumer_key : '' ;
                        $consumer_secret = (isset($api_eship->consumer_secret) && ! empty($api_eship->consumer_secret))? $api_eship->consumer_secret : '';

                        $data  = array(
                            'typeAction' => $type_action,
                            'token'      => $token,
                            'phone'      => $phone,
                            'name'       => $name,
                            'email'      => $email,
                            'dimensions' => $dimensions,
                            'ck'         => ((isset($_POST['ck']) && !empty($_POST['ck']))?  sanitize_text_field($_POST['ck']): $consumer_key),
                            'cs'         => ((isset($_POST['cs']) && !empty($_POST['cs']))? sanitize_text_field($_POST['cs']) : $consumer_secret)
                        );

                        $insert_db = $this->eship_model->insert_data_store_eship($data);

                        if ($insert_db) {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'test'    => array(
                                        $api_eship,
                                        $exist_api_key,
                                        (isset($res_eship_api)? $res_eship_api : '')
                                    ),
                                    'show'    => FALSE,
                                    'message' => (isset($eship_user))? $message : 'Your service is connnect.',
                                    'error'   => (isset($eship_user))? TRUE : FALSE,
                                    'code'    => (isset($eship_user))? 404 : 200
                                ),
                                TRUE
                            );
                        } else {
                            $message = 'Fail to insert data on table';
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'test'    => [
                                        $exist_api_key,
                                        (isset($res_eship_api)? $res_eship_api : '')
                                    ],
                                    'show'    => FALSE,
                                    'message' => $message,
                                    'error'   => TRUE,
                                    'code'    => 500
                                ),
                                TRUE
                            );
                        }
                    }
                }
            } else  {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => array(
                            $exist_api_key
                        ),
                        'show'    => FALSE,
                        'message' => 'Api Key is neccesary',
                        'error'   => TRUE,
                        'code'    => 404
                    ),
                    TRUE
                );
            }
        }

        /*
         * Update api key of eship account on table
         * */
        public function update_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $check_api_key = $this->api_key_eship->getCredentials(sanitize_text_field($_POST['token']));

            if (sanitize_text_field($_POST['typeAction']) == 'update_token') {
                if (is_null($check_api_key) && empty($check_api_key['body'])) {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'test'    => $check_api_key,
                            'show'    => FALSE,
                            'message' => 'Failed to establish connection with eShip.',
                            'error'   => TRUE,
                            'code'    => 500
                        ),
                        TRUE
                    );
                } else {
                    $api_eship = $check_api_key['body'];
                    $json = json_decode($api_eship);
                    if (isset($json->error)) {
                        if ($json->error == 'API Key authentication failed.') {
                            $message  = 'Your API key is incorrect, please check again.';
                            $msg_text = 'To obtain your API key, you must log in to eShip, go to Settings and click on “See your API Key”.';
                            $html     = "<a href='https://myeship.co/#pricing'>Click here.</a>";
                        } else  {
                            $message  = $api_eship->error;
                            $msg_text = '';
                            $html     = "";
                        }

                        $this->response(
                            array(
                                'result'  => NULL,
                                'test'    => $api_eship,
                                'show'    => FALSE,
                                'message' => $message,
                                'msgText' => $msg_text,
                                'error'   => TRUE,
                                'code'    => 404
                            ),
                            TRUE
                        );
                    } else {
                        if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                            $type_action = sanitize_text_field($_POST['typeAction']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => ' typeAction. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['token']) && !empty($_POST['token'])) {
                            $token = sanitize_text_field($_POST['token']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'token. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['name']) && !empty($_POST['name'])) {
                            $name = sanitize_text_field($_POST['name']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'name. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                            $phone = sanitize_text_field($_POST['phone']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'phone. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['email']) && !empty($_POST['email'])) {
                            $email = sanitize_email($_POST['email']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'email. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['user']) && !empty($_POST['user'])) {
                            $user_ut = sanitize_text_field($_POST['user']);
                        } else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'dimensions. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }

                        if (isset($_POST['ck']) && !empty($_POST['ck'])) {
                            $ck = sanitize_text_field($_POST['ck']);
                        } /*else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Consumer Key. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }*/



                        if (isset($_POST['cs']) && !empty($_POST['cs'])) {
                            $cs = sanitize_text_field($_POST['cs']);
                        } /*else {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'show'    => FALSE,
                                    'message' => 'Consumer Secret. This data cannot be empty.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                )
                            );
                        }*/

                        $res_eship_api = '';
                        if ((isset($cs)) && (isset($ck))) {
                            $eship_api = new ESHIP_Api();
                            $json      = json_encode(array(
                                'store_url'       => site_url(),
                                'consumer_secret' => sanitize_text_field($cs),
                                'consumer_key'    => sanitize_text_field($ck)
                            ));
                            $res_eship_api = wp_remote_retrieve_body($eship_api->post('credentials-woo', $json, 45, sanitize_text_field($_POST['token'])));

                            if ($res_eship_api != 'true') {
                                $message = 'Your Consumer key or Consumer secret is incorret.';
                                $this->response(
                                    array(
                                        'result'  => NULL,
                                        'test'    => $res_eship_api,
                                        'show'    => FALSE,
                                        'message' => $message,
                                        'error'   => TRUE,
                                        'code'    => 404
                                    ),
                                    TRUE
                                );
                            }
                        }

                        $data  = array(
                            'typeAction' => $type_action,
                            'token'      => $token,
                            'phone'      => $phone,
                            'name'       => $name,
                            'email'      => $email,
                            'user'       => $user_ut,
                            'cs'         => $cs,
                            'ck'         => $ck,
                        );

                        $result = $this->eship_model->update_data_store_eship($data);

                        if ($result) {
                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'test'    => [
                                        $check_api_key
                                    ],
                                    'show'    => FALSE,
                                    'message' => 'Your data is updated.',
                                    'error'   => FALSE,
                                    'code'    => 201
                                ),
                                TRUE
                            );
                        } else  {

                            $this->response(
                                array(
                                    'result'  => NULL,
                                    'test'    => array(
                                        $check_api_key
                                    ),
                                    'show'    => FALSE,
                                    'message' => 'No updated data.',
                                    'error'   => TRUE,
                                    'code'    => 404
                                ),
                                TRUE
                            );
                        }
                    }
                }
            }

            /*
             * Check if exist a config on table
             * */
            $check_dim = $this->eship_model->get_dimensions_eship();
            if($check_dim) {
                if (sanitize_text_field($_POST['typeAction']) == 'update_status_dimension') {
                    $id_token    = $this->eship_model->get_data_user_eship('id');

                    if (sanitize_text_field($_POST['status']) == 'default') {
                        $dim_token = 1;
                    } else if (sanitize_text_field($_POST['status']) == 'template') {
                        $dim_token = 0;
                    }

                    $result = $this->eship_model->update_data_store_eship(array(
                        'id'         => $id_token,
                        'dimensions' => $dim_token,
                        'typeAction' => 'update_dimension_token'
                    ));

                    if ($result) {
                        $this->response(
                            array(
                                'result'  => NULL,
                                'test'    => $check_api_key,
                                'show'    => FALSE,
                                'message' => 'Your data is update.',
                                'error'   => FALSE,
                                'code'    => 201
                            ),
                            TRUE
                        );
                    } else  {
                        $this->response(
                            array(
                                'result'  => NULL,
                                'test'    => $check_api_key,
                                'show'    => FALSE,
                                'message' => 'Your data not is updated.',
                                'error'   => TRUE,
                                'code'    => 500
                            ),
                            TRUE
                        );
                    }
                }
            } else {
                $this->response(
                    array(
                        'result'  => array(
                            'resource' => 'eshipDimWeModal'
                        ),
                        'test'    => $check_api_key,
                        'show'    => FALSE,
                        'message' => 'Your dimensions of your packages are not configured, please create your dimensions.',
                        'error'   => TRUE,
                        'code'    => 500
                    ),
                    TRUE
                );
            }
        }

        /*
         * Query to obtain the data of the dimensions and weights defined by the seller
         * */
        public function get_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result = $this->eship_model->get_dimensions_eship();
            if ($result) {

                $this->response(
                    array(
                        'result'  => $result,
                        'test'    => $result,
                        'show'    => FALSE,
                        'message' => 'Success.',
                        'error'   => FALSE,
                        'code'    => 200
                    ),
                    TRUE
                );

            } else {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => $result,
                        'show'    => FALSE,
                        'message' => 'You do not have any configuration registered. please register it.',
                        'error'   => TRUE,
                        'code'    => 404
                    ),
                    TRUE
                );
            }
        }

        /*
         * Insert a record in the weights and dimensions table.
         * */
        public function insert_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            if (sanitize_text_field($_POST['typeAction']) == 'add_dimensions') {
                if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                    $type_action = sanitize_text_field($_POST['typeAction']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' typeAction. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }


                if (isset($_POST['aliasEship']) && !empty($_POST['aliasEship'])) {
                    $aliasEship = sanitize_text_field($_POST['aliasEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' aliasEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['lengthEship']) && !empty($_POST['lengthEship'])) {
                    $lengthEship = sanitize_text_field($_POST['lengthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' lengthEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['widthEship']) && !empty($_POST['widthEship'])) {
                    $widthEship = sanitize_text_field($_POST['widthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' widthEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['heightEship']) && !empty($_POST['heightEship'])) {
                    $heightEship = sanitize_text_field($_POST['heightEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' heightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }


                if (isset($_POST['unitDimensionsEship']) && !empty($_POST['unitDimensionsEship'])) {
                    $unitDimensionsEship = sanitize_text_field($_POST['unitDimensionsEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' unitDimensionsEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['weightEship']) && !empty($_POST['weightEship'])) {
                    $weightEship = sanitize_text_field($_POST['weightEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' weightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['unitWeigthEship']) && !empty($_POST['unitWeigthEship'])) {
                    $unitWeigthEship = sanitize_text_field($_POST['unitWeigthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' weightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['statusEship']) && !empty($_POST['statusEship'])) {
                    $status_eship = sanitize_text_field($_POST['statusEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' statusEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                $data = array(
                    'typeAction'          => $type_action,
                    'aliasEship'          => $aliasEship,
                    'lengthEship'         => $lengthEship,
                    'widthEship'          => $widthEship,
                    'heightEship'         => $heightEship,
                    'unitDimensionsEship' => $unitDimensionsEship,
                    'weightEship'         => $weightEship,
                    'unitWeigthEship'     => $unitWeigthEship,
                    'statusEship'         => $status_eship,
                );

                $result   = $this->eship_model->insert_dimensions_eship($data);
                $id_token = $this->eship_model->get_data_user_eship('id');

                $res = $this->eship_model->update_data_store_eship(array(
                    'id'         => $id_token,
                    'dimensions' => 0,
                    'typeAction' => 'update_dimension_token'
                ));

                if ($result) {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'test'    => array(
                                $result,
                                $res
                            ),
                            'show'    => FALSE,
                            'message' => 'Your data was successfully registered.',
                            'error'   => FALSE,
                            'code'    => 201
                        ),
                        TRUE
                    );
                } else  {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'test'    => array(
                                $result
                            ),
                            'show'    => FALSE,
                            'message' => 'Your data was not recorded.',
                            'error'   => TRUE,
                            'code'    => 500
                        ),
                        TRUE
                    );
                }
            } else {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => NULL,
                        'show'    => FALSE,
                        'message' => 'You do not have the necessary permissions.',
                        'error'   => TRUE,
                        'code'    => 404
                    ),
                    TRUE
                );
            }
        }

        /*
         * Update a record in the weights and dimensions table.
         * */
        public function update_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            if (sanitize_text_field($_POST['typeAction']) == 'update_status_dimension'){
                if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                    $type_action = sanitize_text_field($_POST['typeAction']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' typeAction. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['dimId']) && !empty($_POST['dimId'])) {
                    $dim = sanitize_text_field($_POST['dimId']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' dimId. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['status'])) {
                    $statusEship = sanitize_text_field($_POST['status']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' status. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                $data = array(
                    'typeAction' => $type_action,
                    'status'     => $statusEship,
                    'dimId'      => $dim
                );

                $result = $this->eship_model->update_dimensions_eship($data);
            }

            if (sanitize_text_field($_POST['typeAction']) == 'update_dimensions') {
                if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                    $type_action = sanitize_text_field($_POST['typeAction']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' typeAction. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['aliasEship']) && !empty($_POST['aliasEship'])) {
                    $aliasEship = sanitize_text_field($_POST['aliasEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' aliasEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['lengthEship']) && !empty($_POST['lengthEship'])) {
                    $lengthEship = sanitize_text_field($_POST['lengthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' lengthEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['widthEship']) && !empty($_POST['widthEship'])) {
                    $widthEship = sanitize_text_field($_POST['widthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' widthEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['heightEship']) && !empty($_POST['heightEship'])) {
                    $heightEship = sanitize_text_field($_POST['heightEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' heightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }


                if (isset($_POST['unitDimensionsEship']) && !empty($_POST['unitDimensionsEship'])) {
                    $unitDimensionsEship = sanitize_text_field($_POST['unitDimensionsEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' unitDimensionsEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['weightEship']) && !empty($_POST['weightEship'])) {
                    $weightEship = sanitize_text_field($_POST['weightEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' weightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['unitWeigthEship']) && !empty($_POST['unitWeigthEship'])) {
                    $unitWeigthEship = sanitize_text_field($_POST['unitWeigthEship']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' weightEship. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                if (isset($_POST['statusEship']) && !empty($_POST['statusEship'])) {
                    $status_eship = sanitize_text_field($_POST['statusEship']);
                } else {
                    $status_eship = FALSE;
                }

                if (isset($_POST['dim']) && !empty($_POST['dim'])) {
                    $dim = sanitize_text_field($_POST['dim']);
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'show'    => FALSE,
                            'message' => ' dim. This data cannot be empty.',
                            'error'   => TRUE,
                            'code'    => 404
                        )
                    );
                }

                $data = array(
                    'typeAction'          => $type_action,
                    'aliasEship'          => $aliasEship,
                    'lengthEship'         => $lengthEship,
                    'widthEship'          => $widthEship,
                    'heightEship'         => $heightEship,
                    'unitDimensionsEship' => $unitDimensionsEship,
                    'weightEship'         => $weightEship,
                    'unitWeigthEship'     => $unitWeigthEship,
                    'statusEship'         => $status_eship,
                    'dim'                 => $dim,
                );

                $result = $this->eship_model->update_dimensions_eship($data);
            }

            if ($result == 1) {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => array(
                            $result
                        ),
                        'show'    => FALSE,
                        'message' => 'Your data was successfully updated.',
                        'error'   => FALSE,
                        'code'    => 201
                    ),
                    TRUE
                );
            } elseif ($result == 2) {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => $result,
                        'show'    => FALSE,
                        'message' => 'Your dont have permisions.',
                        'error'   => TRUE,
                        'code'    => 404
                    ),
                    TRUE
                );
            } else  {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => $result,
                        'show'    => FALSE,
                        'message' => 'Your data not is updated.',
                        'error'   => TRUE,
                        'code'    => 500
                    ),
                    TRUE
                );
            }
        }

        /*
         * Delete a record in the weights and dimensions table.
         * */
        public function delete_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            //$delId
            if (isset($_POST['typeAction']) && !empty($_POST['typeAction'])) {
                $type_action = sanitize_text_field($_POST['typeAction']);
            } else {
                $this->response(
                    array(
                        'result'  => NULL,
                        'show'    => FALSE,
                        'message' => ' typeAction. This data cannot be empty.',
                        'error'   => TRUE,
                        'code'    => 404
                    )
                );
            }

            if (isset($_POST['delId']) && !empty($_POST['delId'])) {
                $delId = sanitize_text_field($_POST['delId']);
            } else {
                $this->response(
                    array(
                        'result'  => NULL,
                        'show'    => FALSE,
                        'message' => ' delId. This data cannot be empty.',
                        'error'   => TRUE,
                        'code'    => 404
                    )
                );
            }

            $data = array(
                'delId'      => $delId,
                'typeAction' => $type_action
            );

            $result = $this->eship_model->delete_dimension_eship($data);

            if ($result) {
                $id_token = $this->eship_model->get_data_user_eship('id');

                $res = $this->eship_model->update_data_store_eship(array(
                    'id'         => $id_token,
                    'dimensions' => 1,
                    'typeAction' => 'update_dimension_token'
                ));

                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => array(
                            $result,
                            $res
                        ),
                        'show'    => FALSE,
                        'message' => 'Your data was successfully updated.',
                        'error'   => FALSE,
                        'code'    => 201
                    ),
                    TRUE
                );
            } else  {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => 'Test me',
                        'show'    => FALSE,
                        'message' => 'Your data not was updated.',
                        'error'   => TRUE,
                        'code'    => 500
                    ),
                    TRUE
                );
            }
        }

        /*
         * Insert a field in the bulk select.
         * */
        public function load_options_quotations_bulk_eship()
        {
            if ($this->eship_model->get_data_user_eship('id') && $this->eship_model->get_dimensions_eship()) {
                $actions['eship_quotations'] = esc_html('Create multiple shipments');
                return $actions;
            } else {
                $url = get_admin_url() . "admin.php?page=eship_dashboard";
                $text = "<b>eShip</b> <br>Your package dimensions are not configured, please create your dimensions. Click <a href='" . esc_url($url) . "'>here</a>, and select the shipment tab.";
                $adm_notice = new ESHIP_Admin_Notices($text);
                $adm_notice->error_message();
                add_action( 'admin_notices',[$this, 'error_message'] );
            }
        }

        /*
         * Validates that the field exists in the uri.
         * */
        public function search_orders_eship()
        {
            if (isset($_GET['countEship'])) {
                $orders_eship = sanitize_text_field($_GET['countEship']);
            }
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/modals/modal_bulk_eship.php';

        }

        /*
         * Rebuild a uri for query.
         * */
        public function get_quotations_bulk_eship()
        {
            if (isset($_GET['action']) && sanitize_text_field($_GET['action']) == 'eship_quotations') {
                $get_post = array();
                if (is_array($_GET['post'])) {
                    for ($i = 0; $i < count($_GET['post']); $i++) {
                        if (!empty($_GET['post'][$i])) {
                            array_push($get_post, sanitize_text_field($_GET['post'][$i]));
                        }
                    }

                    $count  = implode(',', $get_post);
                    $url    = admin_url() . 'edit.php?post_type=shop_order&countEship=' . $count;
                    //header("Location: " . $url);
                    if ( wp_safe_redirect( $url ) ) {
                        exit;
                    }
                }

            }
        }

        /*
         * Generate a quote.
         * */
        public function get_quotations_orders_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $data = array();

            if (isset($_POST['typeAction']) && sanitize_text_field($_POST['typeAction']) == 'add_quotations_orders') {
                $clean  = sanitize_text_field($_POST['orders']);
                $orders = (!empty($clean))? explode(',', $clean) : 0;
                $error  = array();

                if (!empty($orders) && count($orders) > 0) {

                    for ($i = 0; $i < count($orders); $i++) {
                        $result     = $this->eship_quotation->create($orders[$i]);
                        $result     = json_decode($result);
                        $order_woo  = new ESHIP_Woocommerce_Api();
                        $order      = $order_woo->getOrderApi($orders[$i], 'date');
                        $result->order_id   = $orders[$i];
                        $new_data           = new DateTime($order);
                        $result->date_final = $new_data->format('Y-m-d');
                        array_push($data, $result);
                    }

                    $this->response(
                        array(
                            'result'   => $data,
                            'resError' => $error,
                            'show'     => FALSE,
                            'message'  => 'Success',
                            'error'    => FALSE,
                            'code'     => 201
                        ),
                        TRUE
                    );
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'test'    => $data,
                            'show'    => FALSE,
                            'message' => 'Not orders.',
                            'error'   => TRUE,
                            'code'    => 404
                        ),
                        TRUE
                    );
                }
            } else {
                $this->response(
                    array(
                        'result'  => NULL,
                        'test'    => $data,
                        'show'    => FALSE,
                        'message' => 'The field typeAction is missed.',
                        'error'   => TRUE,
                        'code'    => 404
                    ),
                    TRUE
                );
            }
        }

        /*
         * Generate a shipping guide
         * */
        public function get_shipments_orders_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            $shipments = array();
            $billings  = array();
            $orders    = array();
            $types     = array();

            if(current_user_can('manage_options')) {
                $result = FALSE;
                extract($_POST, EXTR_OVERWRITE);

                if(sanitize_text_field($typeAction) == 'add_shipments') {
                    if (! empty($content)) {
                        for ($i = 0; $i < count($content); $i++) {
                            $clean = sanitize_text_field($content[$i]['value']);
                            $order = explode("_", $clean);
                            array_push($shipments, $order[0]);
                            $order_woo = new ESHIP_Woocommerce_Api();
                            $billing   = $order_woo->getOrderApi($order[1]);
                            array_push($orders, array('meta_data' => $billing['result']->meta_data, 'id' => $billing['result']->id));
                            if (! empty($billing['result']->billing->firts_name) && !empty($billing['result']->billing->last_name)) {
                                $name_final = $billing['result']->billing->firts_name;
                                $last_name  = $billing['result']->billing->last_name;
                            } else  {
                                $name_final = $billing['result']->shipping->first_name;
                                $last_name  = $billing['result']->shipping->last_name;
                            }

                            $name = $name_final . ' ' . $last_name;
                            array_push($billings, $name);
                            array_push($types, $order[3]);
                        }
                        $shipment   = new ESHIP_Shipment($shipments, TRUE);
                        $res        = $shipment->getShipment();
                        $result     = json_decode($res);
                    }
                } else {
                    $this->response(
                        array(
                            'result'  => NULL,
                            'test'    => NULL,
                            'show'    => FALSE,
                            'message' => 'The field typeAction is missed.',
                            'error'   => TRUE,
                            'code'    => 400
                        ),
                        TRUE
                    );
                }

                if ($result) {
                    $this->response(
                        array(
                            'result' => array(
                                'result' => $result,
                                'res'    => $billings,
                                'types'  => $types,
                                'orders' => $orders
                            ),
                            'test'      => array(
                                'result' => $result,
                                'res'    => $billings,
                                'types'  => $types,
                                'orders' => $orders
                            ),
                            'show'    => FALSE,
                            'message' => 'Your shipping guides were generated.',
                            'error'   => FALSE,
                            'code'    => 201
                        ),
                        TRUE
                    );
                } else  {
                    $this->response(
                        array(
                            'result' => array(
                                'result' => $result,
                                'res'    => $billings,
                                'types'  => $types,
                                'orders' => $orders
                            ),
                            'test' => array(
                                'result' => $result,
                                'res'    => $billings,
                                'types'  => $types,
                                'orders' => $orders
                            ),
                            'show'    => FALSE,
                            'message' => 'Your shipping guides were generated.',
                            'error'   => TRUE,
                            'code'    => 400
                        ),
                        TRUE
                    );
                }
            }
        }

        /*
         * Add a box to the woocommerc order view.
         * */
        public function add_meta_boxes_eship()
        {
            $register_view  = 'view_buttons_eship';
            $register_title = "<img class='img-thumbnail' style='max-width:75px;' src='" . ESHIP_PLUGIN_DIR_URL . 'admin/img/eship.png' . "'>";

            if (empty($this->eship_model->get_data_user_eship())) {
                $register_view  = 'view_register_eship';
                $register_title = "<img src='" . ESHIP_PLUGIN_DIR_URL . 'admin/img/eship.png' . "' style='max-width:75px;'>";
            }

            $meta_box = array(
                'id'       => 'woocommerce-order-eship',
                'title'    => $register_title,
                'callback' => [$this, $register_view],
                'view'     => 'shop_order',
                'context'  => 'side',
                'priority' => 'high'
            );

            $add_meta_box = new ESHIP_Build_Add_Meta_Box($meta_box);
            $add_meta_box->run();
        }

        /*
         * Generate the modal buttons for the eship box.
         * */
        public function view_buttons_eship()
        {
            if ($this->eship_model->get_dimensions_eship() && $this->eship_model->get_data_user_eship('id')) {
                $pdf_arr                = array();
                $button_quotation_eship = 'Create Label';

                if (isset($_GET['post']) && isset($_GET['action']) && sanitize_text_field($_GET['action']) == 'edit') {
                    $order          = sanitize_text_field($_GET['post']);
                    $pdf            = new ESHIP_Woocommerce_Api();
                    $pdf_exist      = $pdf->getOrderApi($order);
                    $check_metadata = $pdf_exist['result']->meta_data;

                    if (! empty($pdf_exist['result']->meta_data) && count($pdf_exist['result']->meta_data) > 0) {
                        foreach ($pdf_exist['result']->meta_data  as $key) {
                            if ($key->key == 'tracking_number') {
                                $pdf_arr['tracking_number'] = $key->value;
                            }

                            if ($key->key == 'tracking_provider') {
                                $pdf_arr['tracking_provider'] = $key->value;
                            }

                            if ($key->key == 'tracking_link') {
                                $pdf_arr['tracking_link'] = $key->value;
                            }

                            if ($key->key == 'tracking_url') {
                                $pdf_arr['tracking_url'] = $key->value;
                            }
                        }
                    }

                    $arr_total = array_filter(
                        $pdf_arr,
                        function ($var) {
                            if (empty($var)) {
                                return $var;
                            }
                        }
                    );

                    if (!empty($pdf_arr) && !empty($pdf_arr['tracking_link'])) {
                        $button_quotation_eship  = 'Create Another Label';
                        $modal_shipment_pdf_show = TRUE;
                    }
                }

                $modal_token        = ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/_form_connection.php';
                $modal_custom       = ESHIP_PLUGIN_DIR_PATH . 'admin/partials/buttons_modals/modal_custom.php';
                $modal_shipment_pdf = ESHIP_PLUGIN_DIR_PATH . 'admin/partials/buttons_modals/shipment_sheet.php';

                require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/buttons_modals/buttons.php';
            } else {
                $url = get_admin_url() . "admin.php?page=eship_dashboard";
                $text = "<b>eShip</b> <br>Your package dimensions are not configured, please create your dimensions. Click <a href='" .  esc_url($url) . "'>here</a>, and select the shipment tab.";
                $adm_notice = new ESHIP_Admin_Notices($text);
                $adm_notice->error_message();
                add_action( 'admin_notices',[$this, 'error_message'] );
            }
        }

        /*
         * Controls the registration view in case the user does not have an account yet
         * */
        public function view_register_eship()
        {
            $text_modal_ak        = 'Connect to ESHIP';
            $text_title_api_key   = 'Register API Key';
            $text_api_key         = 'To obtain your eShip API key, you login into your eShip account 
                                        <a href="https://app.myeship.co/" target="_blank">(app.myeship.co)</a>, go to 
                                        "Settings" and click on "View your API Key".
                                        <b>Important! It\'s necessary to be subscribed to a paid plan to access this service.</b>
                                        <a href="https://myeship.co/#pricing" target="_blank">Click here.</a>';
            $id_api_key           = 'tokenEshipModal';
            $btn_account_ak_modal = 'Register API Key';
            $title_eship_account  = 'I do not have an account of ESHIP';
            $text_eship_account   = '';
            $btn_account_ak       = 'I have ESHIP account';
            $btn_account_ak_text  = '';
            $btn_account          = 'Register Now';
            $btn_account_link     = 'https://app.myeship.co/en/login';
            $modal_token          =  ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/_form_connection.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/connection.php';
        }

        /*
         * Generate multiple quotes.
         * */
        public function get_quotation_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            if (isset($_POST['order_id'])) {
                $post_order = sanitize_text_field($_POST['order_id']);
                $result = $this->eship_quotation->create($post_order);
                $result = json_decode($result);

                if ($result) {
                    if ($result->status == 400 || (isset($result->error))) {
                        $message = $result->message;
                        $error = TRUE;
                    } else {
                        $woo          = new ESHIP_Woocommerce_Api();
                        $update_order = [];

                        if ($result->object_id) {
                            array_push($update_order,
                                $woo->setOrderApi(
                                    $post_order,
                                    array(
                                        'object_id' => $result->object_id
                                    ),
                                    'meta_data_object_id'
                                ),
                                $woo->setOrderApi(
                                    $post_order,
                                    array(
                                        'tracking_number' => $result->tracking_number
                                    ),
                                    'meta_data_tracking_number'
                                ),
                                $woo->setOrderApi(
                                    $post_order,
                                    array(
                                        'provider' => $result->provider
                                    ),
                                    'meta_data_provider'
                                ),
                                $woo->setOrderApi(
                                    $post_order,
                                    array(
                                        'tracking_link' => $result->label_url
                                    ),
                                    'meta_data_tracking_link'
                                ),
                                $woo->setOrderApi(
                                    $post_order,
                                    array(
                                        'tracking_url' => $result->tracking_url_provider
                                    ),
                                    'meta_data_tracking_linkmeta_data_tracking_url'
                                )
                            );

                            $message = 'Your quote is created';
                            $error = FALSE;
                        }
                    }

                    $this->response(
                        array(
                            'result'    => $result,
                            'test'      => array(
                                'result'    => $result,
                                'upOrder'   => $update_order,
                                'order'     => $post_order
                            ),
                            'show'      => FALSE,
                            'message'   => $message,
                            'error'     => $error,
                            'code'      => 201
                        ),
                        TRUE
                    );
                } else  {

                    $this->response(
                        array(
                            'result'    => $result,
                            'test'      => NULL,
                            'show'      => FALSE,
                            'message'   => (isset($result['error']))? $result['message'] : FALSE,
                            'error'     => TRUE,
                            'code'      => 404
                        ),
                        TRUE
                    );
                }

            } else {
                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => NULL,
                        'show'      => FALSE,
                        'message'   => 'There is no order selected.',
                        'error'     => TRUE,
                        'code'      => 404
                    ),
                    TRUE
                );
            }
        }

        /*
         * Generate multiple shipping guides.
         * */
        public function get_shipment_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            if(current_user_can('manage_options')) {
                $result = FALSE;

                if(sanitize_text_field($_POST['typeAction']) == 'create_shipment') {
                    $shipment   = new ESHIP_Shipment(sanitize_text_field($_POST['rateId']));
                    $result     = $shipment->getShipment();
                    $result     = json_decode($result);


                    if ($result) {
                        $woo = new ESHIP_Woocommerce_Api();
                        $tracking_number    = FALSE;
                        $provider           = FALSE;
                        $tracking_link      = FALSE;
                        $tracking_url       = FALSE;

                        if (sanitize_text_field($_POST['order'])) {
                            $tracking_number = $woo->setOrderApi(
                                sanitize_text_field($_POST['order']),
                                array('tracking_number' => $result->tracking_number),
                                'meta_data_tracking_number'
                            );
                            $provider = $woo->setOrderApi(
                                sanitize_text_field($_POST['order']),
                                array('tracking_provider' => $result->provider),
                                'meta_data_provider'
                            );
                            $tracking_link = $woo->setOrderApi(
                                sanitize_text_field($_POST['order']),
                                array('tracking_link' => $result->label_url),
                                'meta_data_tracking_link'
                            );
                            $tracking_url = $woo->setOrderApi(
                                sanitize_text_field($_POST['order']),
                                array('tracking_url' => $result->tracking_url_provider),
                                'meta_data_tracking_url'
                            );
                        }

                        $this->response(
                            array(
                                'result'    => $result,
                                'test'      => array(
                                    $result,
                                    $tracking_link,
                                    $tracking_number,
                                    $tracking_url,
                                    $provider
                                ),
                                'show'      => FALSE,
                                'message'   => '',
                                'error'     => FALSE,
                                'code'      => 201
                            ),
                            TRUE
                        );
                    } else  {
                        $this->response(
                            array(
                                'result'    => NULL,
                                'test'      => NULL,
                                'show'      => FALSE,
                                'message'   => 'Your shipping guides were generated.',
                                'error'     => TRUE,
                                'code'      => 400
                            ),
                            TRUE
                        );
                    }
                } else {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => NULL,
                            'show'      => FALSE,
                            'message'   => 'The field typeAction is missed.',
                            'error'     => TRUE,
                            'code'      => 400
                        ),
                        TRUE
                    );
                }
            }
        }

        /*
         * Convert the data into format JSON
         * */
        private function response($data, $test = FALSE)
        {
            if ($test) {
                $response =  array(
                    'result'    => $data['result'],
                    'test'      => $data['test'],
                    'show'      => $data['show'],
                    'message'   => $data['message'],
                    'msgText'   => (isset($data['msgText']))? $data['msgText'] : '',
                    'error'     => $data['error'],
                    'code'      => $data['code']
                );
            } else {
                $response =  array(
                    'result'    => $data['result'],
                    'show'      => $data['show'],
                    'message'   => $data['message'],
                    'msgText'   => (isset($data['msgText']))? $data['msgText'] : '',
                    'error'     => $data['error'],
                    'code'      => $data['code']
                );
            }

            echo json_encode($response);
            wp_die();
        }
    }
