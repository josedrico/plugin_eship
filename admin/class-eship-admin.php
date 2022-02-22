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

        public function insert_quotations_bulk_eship()
        {
            $check_dim = $this->eship_model->get_dimensions_eship();
            $id_token = $this->eship_model->get_data_user_eship('id');
            if ($id_token && $check_dim) {
                $actions['eship_quotations'] = 'Create multiple shipments';
                return $actions;
            } else {
                $text = "<b>eShip</b> <br>Your package dimensions are not configured, please create your dimensions. Click <a href='" .  get_admin_url() . "admin.php?page=eship_dashboard'>here</a>, and select the shipment tab.";
                $adm_notice = new ESHIP_Admin_Notices($text);
                $adm_notice->error_message();
                add_action( 'admin_notices',[$this, 'error_message'] );
            }

        }

        public function get_quotations_bulk_eship()
        {
            if (isset($_GET['action']) && $_GET['action'] == 'eship_quotations') {
                $count  = implode(',', $_GET['post']);
                $url    = admin_url() . 'edit.php?post_type=shop_order&countEship=' . $count;
                header("Location: " . $url);
                //die();
            }
        }

        public function search_data_eship()
        {
            if (isset($_GET['countEship'])) {
                $orders_eship = $_GET['countEship'];
            }
            require_once ESHIP_PLUGIN_DIR_PATH . 'admin/partials/modals/modal_bulk_eship.php';

        }

        public function get_check_woo_errors_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $response   = array();

            $api  = $this->api_key_eship->getCredentials();
            $json = json_decode($api['body']);

            if ($_POST['typeAction'] == 'check_woo_errors_all') {
                $id_token = $this->eship_model->get_data_user_eship('id');
                if ($id_token) {
                    $test = new ESHIP_Woocommerce_Api();
                    $check = $test->test();

                    if (isset($check['error'])) {
                        $response = array(
                            'result'    => '',
                            'message'   => $check['message'],
                            //'api'       => $json,
                            'error'     => TRUE,
                            'code'      => 500
                        );
                    } else {
                        $response = array(
                            'result'    => '',
                            'message'   => 'OK',
                            'error'     => FALSE,
                            //'api'       => $json,
                            'code'      => 200
                        );
                    }
                } else {
                    $response = array(
                        'result'    => $id_token,
                        'message'   => 'No api key',
                        //'api'       => $json,
                        'error'     => FALSE,
                        'code'      => 200
                    );
                }

            } else {
                $response = array(
                    'result'    => '',
                    'message'   => 'OK',
                    'error'     => FALSE,
                    //'api'       => $json,
                    'code'      => 200
                );
            }

            echo json_encode($response);
            wp_die();
        }

        public function check_connect_woo_message_eship()
        {
            $id_token = $this->eship_model->get_data_user_eship('id');
            if ($id_token) {
                $test = new ESHIP_Woocommerce_Api();
                $check = $test->test();

                if (isset($check['error'])) {
                    $notices = new ESHIP_Admin_Notices($check['message']);
                    $notices->error_message();
                }
            }
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

        public function view_buttons_eship()
        {
            $check_dim = $this->eship_model->get_dimensions_eship();
            $id_token = $this->eship_model->get_data_user_eship('id');
            if ($check_dim && $id_token) {
                $pdf_arr                = array();
                $button_quotation_eship = 'Ship Now';

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

                    if (empty($arr_total)) {
                        $button_quotation_eship     = 'Create Another Label';
                        $modal_shipment_pdf_show    = TRUE;
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

        public function view_register_eship()
        {
            $text_modal_ak          = 'Connect to ESHIP';
            $text_title_api_key     = 'Register API Key';
            $text_api_key = 'To obtain your eShip API key, you login into your eShip account 
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

        public function get_shipment_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $response = array();

            if(current_user_can('manage_options')) {
                $result = FALSE;
                extract($_POST, EXTR_OVERWRITE);

                if($typeAction == 'create_shipment') {
                    $shipment   = new ESHIP_Shipment($rateId);
                    $result     = $shipment->getShipment();
                    $result     = json_decode($result);
                }

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
                    }
                    $response = array(
                        'result'    => $result,
                        'tracking_link' => $tracking_link,
                        'redirect'  => '',
                        'error'     => FALSE,
                        'code'      => 201
                    );
                } else  {
                    $response = array(
                        'result'    => $result,//'No se genero tu guía',
                        'redirect'  => FALSE,
                        'error'     => TRUE,
                        'code'      => 404
                    );
                }

                echo json_encode($response);
                wp_die();
            }
        }

        public function get_quotation_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result = FALSE;
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

                    $response = array(
                        'result'    => $result,
                        'upOrder'   => $update_order,
                        'order'     => $_POST['order_id'],
                        'redirect'  => FALSE,
                        'error'     => FALSE,
                        'code'      => 201
                    );
                } else  {
                    $response = array(
                        'result'    => $result,
                        'res'       => (isset($result['error']))? $result['message'] : $result,
                        'message'   => '',
                        'error'     => TRUE,
                        'code'      => 404
                    );
                }

            } else {
                $response = array(
                    'result'    => 'No se conecto con las APIs',
                    'error'     => TRUE,
                    'code'      => 500
                );
            }
            echo json_encode($response);
            wp_die();
        }

        public function get_quotation_orders_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $data = array();

            if (isset($_POST['typeAction'])) {
                $orders = (isset($_POST['orders']))? explode(',', $_POST['orders']) : FALSE;
                if (is_array($orders)) {
                    for ($i = 0; $i < count($orders); $i++) {
                        $result     = $this->eship_quotation->create($orders[$i], 'date');
                        $result     = json_decode($result);
                        $order_woo  = new ESHIP_Woocommerce_Api();
                        $order      = $order_woo->getOrderApi($orders[$i], 'date');
                        $result->order_id   = $orders[$i];
                        $new_data = new DateTime($order);
                        $result->date_final = $new_data->format('Y-m-d');

                        array_push($data, $result);
                    }
                    $response = array(
                        'result' => $data,
                        'error'  => FALSE,
                        'code'   => 201
                    );
                } else {
                    $response = array(
                        'result' => 'Sin ordenes',
                        'error'  => TRUE,
                        'code'   => 404
                    );
                }
            } else {
                $response = array(
                    'result'    => 'No existe typeAction',
                    'error'     => TRUE,
                    'code'      => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }

        public function get_shipments_orders_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $response = array();
            $shipments = array();
            $billings = array();

            if(current_user_can('manage_options')) {
                $result = FALSE;
                extract($_POST, EXTR_OVERWRITE);

                if($typeAction == 'add_shipments') {
                    if (! empty($content)) {
                        for ($i = 0; $i < count($content); $i++) {
                            $order = explode("_", $content[$i]['value']);
                            array_push($shipments, $order[0]);
                            $order_woo = new ESHIP_Woocommerce_Api();
                            $billings = $order_woo->getOrderApi($order[1]);

                            if (! empty($billing->billing->firts_name)) {
                                $name_final = $billing->billing->firts_name;
                            } else  {
                                $name_final = $billings->shipping->first_name;
                            }

                            if (! empty($billing->billing->last_name)) {
                                $last_name = $billing->billing->last_name;
                            } else  {
                                $last_name = $billings->shipping->last_name;
                            }

                            $name = $name_final . ' ' . $last_name;
                            array_push($billings, $name);
                        }
                        $shipment = new ESHIP_Shipment($shipments, TRUE);
                        $res = $shipment->getShipment();
                        $result = json_decode($res);
                    }
                }

                if ($result) {
                    $response = array(
                        'result'    => $result,
                        'res'       => $billings,
                        'redirect'  => FALSE,
                        'error'     => FALSE,
                        'code'      => 201
                    );
                } else  {
                    $response = array(
                        'result'    => 'No se generaron tus guías',
                        'redirect'  => FALSE,
                        'error'     => TRUE,
                        'code'      => 404
                    );
                }

                echo json_encode($response);
                wp_die();
            }
        }

        public function get_api_key_eship(){
            $api  = $this->api_key_eship->getCredentials();
            $json = json_decode($api['body']);
            return $json->consumer_secret;
        }

        public function insert_token_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');

            if (isset($_POST['token']) && ! empty($_POST['token'])) {
                $exist_api_key = $this->api_key_eship->getCredentials($_POST['token']);
                if ($exist_api_key) {
                    if (! isset($exist_api_key['body'])) {
                        $response = array(
                            'message'   => 'No se retorno el body',
                            'result'    => FALSE,
                            'error'     => TRUE,
                            'updateEffect' => TRUE,
                            'code'      => 500
                        );
                    } else {

                        if (!$this->eship_model->get_data_user_eship('token')) {
                            $api_eship = json_decode($exist_api_key['body']);
                        } else {
                            $api_eship = FALSE;
                        }


                        if (isset($api_eship->error)) {
                            $response = array(
                                'message'   => $api_eship->error,
                                'result'    => FALSE,
                                'updateEffect' => TRUE,
                                'error'     => TRUE,
                                'code'      => 500
                            );
                        } else {
                            $insert_db = $this->eship_model->insert_data_store_eship($_POST);
                            if ($insert_db) {
                                $response = array(
                                    'message'      => 'Your service is connnect',
                                    'result'       => $insert_db,
                                    'updateEffect' => TRUE,
                                    'error'        => FALSE,
                                    'code'         => 200
                                );
                            } else {
                                $response = array(
                                    'message'       => 'Fail to insert data on table',
                                    'result'        => $insert_db,
                                    'res'           => $_POST,
                                    'exist_api_key' => $api_eship,
                                    'updateEffect'  => TRUE,
                                    'error'         => TRUE,
                                    'code'          => 500
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

        public function get_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result = $this->eship_model->get_dimensions_eship();
            if ($result) {
                $response = array(
                    'result'    => $result,
                    'message'   => 'Done!',
                    'error'     => FALSE,
                    //'redirect'  => TRUE,
                    'code'      => 200
                );
            } else {
                $response = array(
                    'result'    => $result,
                    'error'     => TRUE,
                    'message'   => 'No data!',
                    'code'      => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }

        public function insert_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result     = $this->eship_model->insert_dimensions_eship($_POST);
            $id_token   = $this->eship_model->get_data_user_eship('id');

            $res = $this->eship_model->update_data_store_eship(array(
                'id'         => $id_token,
                'dimensions' => 0,
                'typeAction' => 'update_dimension_token'
            ));

            if ($result) {
                $response = array(
                    'result'    => 'Exito',
                    'res'       => $result,
                    //'post'      => $_POST,
                    'redirect'  => TRUE,
                    'error'     => FALSE,
                    'code'      => 201
                );
            } else  {
                $response = array(
                    'result'    => 'Error',
                    'res'       => $result,
                    'error'     => TRUE,
                    'code'      => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }

        public function update_dimensions_eship()
        {
            check_ajax_referer('eship_sec', 'nonce');
            $result = $this->eship_model->update_dimension_eship($_POST);

            if ($_POST['typeAction'] == 'update_status_dimension') {

                if ($result == 1) {
                    $response = array(
                        'result'    => 'Done!',
                        'updateEffect' => $result,
                        'message'   => 'Your data update.',
                        'error'     => FALSE,
                        'code'      => 201
                    );
                } else  {
                    $response = array(
                        'result'  => 'No updated',
                        'message' => 'Your data not is update',
                        'error'   => TRUE,
                        'code'    => 404
                    );
                }

                echo json_encode($response);
                wp_die();
            }

            if ($_POST['typeAction'] == 'update_dimensions') {
                if ($result) {
                    $response = array(
                        'result'   => 'Done!',
                        'redirect' => TRUE,
                        'error'    => FALSE,
                        'message'  => 'Your data update',
                        'code'     => 201
                    );
                } else  {
                    $response = array(
                        'result'  => 'No updated',
                        'error'   => TRUE,
                        'message' => 'Your data no update',
                        'code'    => 404
                    );
                }

                echo json_encode($response);
                wp_die();
            }
        }

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

                $response = array(
                    'result'    => 'Done!',
                    //'res'       => $res,
                    'redirect'  => TRUE,
                    'error'     => FALSE,
                    'message' => 'Your data is deleted',
                    'code'      => 201
                );
            } else  {
                $response = array(
                    'result'    => 'No deleted',
                    'error'     => TRUE,
                    'message' => 'Your data not is deleted',
                    'code'      => 404
                );
            }

            echo json_encode($response);
            wp_die();
        }
    }

