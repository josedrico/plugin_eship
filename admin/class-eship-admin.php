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
     * @subpackage ESHIP/ESHIP_Admin
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
            $config_data  = array();
            $instructions_ak = 'To obtain your API key, login into your eShip account <a href="https://app.myeship.co/" target="_blank">(app.myeship.co)</a>, go to "Settings" and click on "See your API Key';
            $dimensions   = $this->eship_model->get_dimensions_eship();

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

        /*
         * Insert api key of eship account on table
         * */
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
                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => $exist_api_key,
                        'show'      => FALSE,
                        'message'   => 'Api Key is neccesary',
                        'error'     => TRUE,
                        'code'      => 404
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
            $check_api_key = $this->api_key_eship->getCredentials($_POST['token']);

            if ($_POST['typeAction'] == 'update_token') {
                if (is_null($check_api_key) && empty($check_api_key['body'])) {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => $check_api_key,
                            'show'      => FALSE,
                            'message'   => 'Failed to establish connection with eShip.',
                            'error'     => TRUE,
                            'code'      => 500
                        ),
                        TRUE
                    );
                } else {
                    $api_eship = $check_api_key['body'];
                    if (isset($api_eship->error)) {
                        if ($api_eship->error == 'API Key authentication failed.') {
                            $message = 'Your eShip api key is wrong. Please follow the instructions to connect your eShip account to this WooCommerce Store';
                        } else  {
                            $message = $api_eship->error;
                        }

                        $this->response(
                            array(
                                'result'    => NULL,
                                'test'      => $api_eship,
                                'show'      => FALSE,
                                'message'   => $message,
                                'error'     => TRUE,
                                'code'      => 404
                            ),
                            TRUE
                        );
                    } else {
                        $result = $this->eship_model->update_data_store_eship($_POST);
                        if ($result) {
                            $this->response(
                                array(
                                    'result'    => NULL,
                                    'test'      => $check_api_key,
                                    'show'      => FALSE,
                                    'message'   => 'Your data is updated.',
                                    'error'     => FALSE,
                                    'code'      => 201
                                ),
                                TRUE
                            );
                        } else  {

                            $this->response(
                                array(
                                    'result'    => NULL,
                                    'test'      => $check_api_key,
                                    'show'      => FALSE,
                                    'message'   => 'No updated data.',
                                    'error'     => TRUE,
                                    'code'      => 404
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
                        $this->response(
                            array(
                                'result'    => NULL,
                                'test'      => $check_api_key,
                                'show'      => FALSE,
                                'message'   => 'Your data is update.',
                                'error'     => FALSE,
                                'code'      => 201
                            ),
                            TRUE
                        );
                    } else  {
                        $this->response(
                            array(
                                'result'    => NULL,
                                'test'      => $check_api_key,
                                'show'      => FALSE,
                                'message'   => 'Your data not is updated.',
                                'error'     => TRUE,
                                'code'      => 500
                            ),
                            TRUE
                        );
                    }
                }
            } else {
                $this->response(
                    array(
                        'result'    => array(
                            'resource' => 'eshipDimWeModal'
                        ),
                        'test'      => $check_api_key,
                        'show'      => FALSE,
                        'message'   => 'Your dimensions of your packages are not configured, please create your dimensions.',
                        'error'     => TRUE,
                        'code'      => 500
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
                        'result'    => $result,
                        'test'      => $result,
                        'show'      => FALSE,
                        'message'   => 'Success.',
                        'error'     => FALSE,
                        'code'      => 200
                    ),
                    TRUE
                );

            } else {
                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => $result,
                        'show'      => FALSE,
                        'message'   => 'You do not have any configuration registered. please register it.',
                        'error'     => TRUE,
                        'code'      => 404
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
            if ($_POST['typeAction'] == 'add_dimensions') {
                $result     = $this->eship_model->insert_dimensions_eship($_POST);
                $id_token   = $this->eship_model->get_data_user_eship('id');

                $res = $this->eship_model->update_data_store_eship(array(
                    'id'         => $id_token,
                    'dimensions' => 0,
                    'typeAction' => 'update_dimension_token'
                ));

                if ($result) {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => array(
                                $result,
                                $res
                            ),
                            'show'      => FALSE,
                            'message'   => 'Your data was successfully registered.',
                            'error'     => FALSE,
                            'code'      => 201
                        ),
                        TRUE
                    );
                } else  {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => $result,
                            'show'      => FALSE,
                            'message'   => 'Your data was not recorded.',
                            'error'     => TRUE,
                            'code'      => 500
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
                        'message'   => 'You do not have the necessary permissions.',
                        'error'     => TRUE,
                        'code'      => 404
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

            if ($_POST['typeAction'] == 'update_status_dimension' || $_POST['typeAction'] == 'update_dimensions') {
                $result = $this->eship_model->update_dimensions_eship($_POST);

                if ($result == 1) {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => array(
                                $result,
                                $_POST
                            ),
                            'show'      => FALSE,
                            'message'   => 'Your data was successfully updated.',
                            'error'     => FALSE,
                            'code'      => 201
                        ),
                        TRUE
                    );
                } elseif ($result == 2) {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => $result,
                            'show'      => FALSE,
                            'message'   => 'Your dont have permisions.',
                            'error'     => TRUE,
                            'code'      => 404
                        ),
                        TRUE
                    );
                } else  {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => $result,
                            'show'      => FALSE,
                            'message'   => 'Your data not is updated.',
                            'error'     => TRUE,
                            'code'      => 500
                        ),
                        TRUE
                    );
                }
            } else {
                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => $_POST,
                        'show'      => FALSE,
                        'message'   => 'You do not have the necessary permissions.',
                        'error'     => TRUE,
                        'code'      => 500
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
            $result = $this->eship_model->delete_dimension_eship($_POST);

            if ($result) {
                $id_token = $this->eship_model->get_data_user_eship('id');

                $res = $this->eship_model->update_data_store_eship(array(
                    'id'         => $id_token,
                    'dimensions' => 1,
                    'typeAction' => 'update_dimension_token'
                ));

                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => array(
                            $result,
                            $res
                        ),
                        'show'      => FALSE,
                        'message'   => 'Your data was successfully updated.',
                        'error'     => FALSE,
                        'code'      => 201
                    ),
                    TRUE
                );
            } else  {
                $this->response(
                    array(
                        'result'    => NULL,
                        'test'      => $_POST,
                        'show'      => FALSE,
                        'message'   => 'Your data not was updated.',
                        'error'     => TRUE,
                        'code'      => 500
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
                $actions['eship_quotations'] = 'Create multiple shipments';
                return $actions;
            } else {
                $text = "<b>eShip</b> <br>Your package dimensions are not configured, please create your dimensions. Click <a href='" .  get_admin_url() . "admin.php?page=eship_dashboard'>here</a>, and select the shipment tab.";
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
                $orders_eship = $_GET['countEship'];
            }
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/modals/modal_bulk_eship.php';

        }

        /*
         * Rebuild a uri for query.
         * */
        public function get_quotations_bulk_eship()
        {
            if (isset($_GET['action']) && $_GET['action'] == 'eship_quotations') {
                $count  = implode(',', $_GET['post']);
                $url    = admin_url() . 'edit.php?post_type=shop_order&countEship=' . $count;
                header("Location: " . $url);
            }
        }

        /*
         * Generate a quote.
         * */
        public function get_quotations_orders_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $data = array();

            if (isset($_POST['typeAction']) == 'add_quotations_orders') {
                $orders = (isset($_POST['orders']))? explode(',', $_POST['orders']) : FALSE;
                if (is_array($orders)) {
                    for ($i = 0; $i < count($orders); $i++) {
                        $result     = $this->eship_quotation->create($orders[$i], 'date');
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
                            'result'    => $data,
                            'test'      => array(
                                $data,
                                $result
                            ),
                            'show'      => FALSE,
                            'message'   => 'Success.',
                            'error'     => FALSE,
                            'code'      => 201
                        ),
                        TRUE
                    );
                } else {
                    $this->response(
                        array(
                            'result'    => NULL,
                            'test'      => $data,
                            'show'      => FALSE,
                            'message'   => 'Not orders.',
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
                        'test'      => $data,
                        'show'      => FALSE,
                        'message'   => 'The field typeAction is missed.',
                        'error'     => TRUE,
                        'code'      => 404
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

            $shipments  = array();
            $billings   = array();
            $orders     = array();
            $types      = array();

            if(current_user_can('manage_options')) {
                $result = FALSE;
                extract($_POST, EXTR_OVERWRITE);

                if($typeAction == 'add_shipments') {
                    if (! empty($content)) {
                        for ($i = 0; $i < count($content); $i++) {
                            $order = explode("_", $content[$i]['value']);
                            array_push($shipments, $order[0]);
                            $order_woo  = new ESHIP_Woocommerce_Api();
                            $billing    = $order_woo->getOrderApi($order[1]);
                            array_push($orders, array('meta_data' => $billing->meta_data, 'id' => $billing->id));
                            if (! empty($billing->billing->firts_name) && !empty($billing->billing->last_name)) {
                                $name_final = $billing->billing->firts_name;
                                $last_name  = $billing->billing->last_name;
                            } else  {
                                $name_final = $billing->shipping->first_name;
                                $last_name  = $billing->shipping->last_name;
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

                if ($result) {
                    $this->response(
                        array(
                            'result'    => array(
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
                            'show'      => FALSE,
                            'message'   => 'Your shipping guides were generated.',
                            'error'     => FALSE,
                            'code'      => 201
                        ),
                        TRUE
                    );
                } else  {
                    $this->response(
                        array(
                            'result'    => array(
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
                            'show'      => FALSE,
                            'message'   => 'Your shipping guides were generated.',
                            'error'     => TRUE,
                            'code'      => 400
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
                'id'        => 'woocommerce-order-eship',
                'title'     => $register_title,
                'callback'  => [$this, $register_view],
                'view'      => 'shop_order',
                'context'   => 'side',
                'priority'  => 'high'
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

                if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
                    $order          = $_GET['post'];
                    $pdf            = new ESHIP_Woocommerce_Api();
                    $pdf_exist      = $pdf->getOrderApi($order);
                    $check_metadata = $pdf_exist->meta_data;

                    if (! empty($pdf_exist->meta_data) && count($pdf_exist->meta_data) > 0) {
                        foreach ($pdf_exist->meta_data  as $key) {
                            if ($key->key == 'tracking_number') {
                                $pdf_arr['tracking_number'] = $key->value;
                            }

                            if ($key->key == 'provider') {
                                $pdf_arr['provider'] = $key->value;
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
                $text = "<b>eShip</b> <br>Your package dimensions are not configured, please create your dimensions. Click <a href='" .  get_admin_url() . "admin.php?page=eship_dashboard'>here</a>, and select the shipment tab.";
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
            $text_modal_ak          = 'Connect to ESHIP';
            $text_title_api_key     = 'Register API Key';
            $text_api_key           = 'To obtain your eShip API key, you login into your eShip account 
                                        <a href="https://app.myeship.co/" target="_blank">(app.myeship.co)</a>, go to 
                                        "Settings" and click on "View your API Key".';
            $id_api_key             = 'tokenEshipModal';
            $btn_account_ak_modal   = 'Register API Key';
            $title_eship_account    = 'I do not have an account of ESHIP';
            $text_eship_account     = '';
            $btn_account_ak         = 'I have ESHIP account';
            $btn_account_ak_text    = '';
            $btn_account            = 'Register Now';
            $btn_account_link       = 'https://app.myeship.co/en/login';
            $modal_token            =  ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/_form_connection.php';
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/connection/connection.php';
        }

        /*
         * Generate multiple quotes.
         * */
        public function get_quotation_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            if (isset($_POST['order_id'])) {
                $result = $this->eship_quotation->create($_POST['order_id']);
                $result = json_decode($result);

                if ($result && !(isset($result->error))) {
                    $woo          = new ESHIP_Woocommerce_Api();
                    $update_order = FALSE;
                    if ($result->object_id) {
                        $update_order = $woo->setOrderApi(
                            $_POST['order_id'],
                            array(
                                'object_id' => $result->object_id
                            ),
                            'meta_data_object_id'
                        );
                    }

                    $this->response(
                        array(
                            'result'    => $result,
                            'test'      => array(
                                'result'    => $result,
                                'upOrder'   => $update_order,
                                'order'     => $_POST['order_id']
                            ),
                            'show'      => FALSE,
                            'message'   => 'Your quote is created',
                            'error'     => FALSE,
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
                extract($_POST, EXTR_OVERWRITE);

                if($typeAction == 'create_shipment') {
                    $shipment   = new ESHIP_Shipment($rateId);
                    $result     = $shipment->getShipment();
                    $result     = json_decode($result);


                    if ($result) {
                        $woo = new ESHIP_Woocommerce_Api();
                        $tracking_number    = FALSE;
                        $provider           = FALSE;
                        $tracking_link      = FALSE;
                        if ($order) {
                            $tracking_number = $woo->setOrderApi(
                                $order,
                                array('tracking_number' => $result->tracking_number),
                                'meta_data_tracking_number'
                            );
                            $provider = $woo->setOrderApi(
                                $order,
                                array('provider' => $result->provider),
                                'meta_data_provider'
                            );
                            $tracking_link = $woo->setOrderApi(
                                $order,
                                array('tracking_link' => $result->label_url),
                                'meta_data_tracking_link'
                            );
                            $tracking_url = $woo->setOrderApi(
                                $order,
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
