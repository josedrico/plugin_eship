<?php
namespace EshipAdminApi;
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
 * Config and queries to api's.
 *
 * @link       https://eship.com
 * @since      1.0.0
 *
 * @package    ESHIP_blank
 * @subpackage ESHIP_blank/admin
 */

class ESHIP_Admin_Api {
    public function woocommerce_conn_eship($type, $parameters = FALSE, $other = FALSE) {
        $woocommerce = new Client(
        //Page principal
        /*
        'http://18.191.235.204/wp-plugin-eship',
        'ck_e1e2f573ca6d3237a02a7442952fa37806ef47ea',
        'cs_fc047f331954ffa83623ed0f47c927afee406438',
        [
            'wp_api' => true,
            'version' => 'wc/v3'
        ]
        */
        // Sitio de pruebas
            'http://wp.eship.mylocal:8888',
            'ck_8fc0c1a4fbc9fd2137a6b75c2728908f9346eb15',
            'cs_46c0207837b87425d850fff14656ffef0621b4bc',
            [
                'wp_api'    => true,
                'version'   => 'wc/v3'
            ]
        );

        //https://github.com/woocommerce/wc-api-php
        switch($type) {
            case 'product':
                return $woocommerce->get('products/' . $other);

            case 'countries':
                $iso = explode(':', $other);
                $result =  $woocommerce->get('data/countries/' . $iso[0]);
                $data = array();
                if(isset($result) && !empty($result)) {

                    foreach ($result->states as $key) {
                        if ($key->code == $iso[1]) {
                            $new_arr = array(
                                'country'       => $result->name,
                                'country_code'  => $result->code,
                                'state_code'    => $key->code,
                                'state'         => $key->name
                            );
                            array_push($data, $new_arr);
                        }
                    }
                }
                return $data;

            case 'settings_general':
                return $woocommerce->get('settings/general');
            case 'list_orders':
                return $woocommerce->get('orders');
            case 'order_get':
                return $woocommerce->get('orders', $parameters);
            default:
                return $woocommerce->get('');
        }
    }

    private function wp_api_get_eship($api, $api_key, $uri, $data) {
        return wp_remote_get( $api . $uri, array(
            'headers' => array(
                'content-Type' => 'Application/json',
                'api-key' => $api_key
            )
        ));
    }

    private function wp_api_post_eship($api, $api_key, $uri, $body) {
        return wp_remote_post( $api . $uri, array(
                'method'      => 'POST',
                //'timeout'     => 45,
                //'redirection' => 5,
                //'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'content-Type'  => 'Application/json',
                    'api-key'       => $api_key
                ),
                'body'      => $body,
                'cookies'   => array()
            )
        );
    }

    private function quotation_api_eship($type, $uri, $body) {
        $api        = "https://api.myeship.co/rest/";
        $api_key    = 'eship_prod_835261c341f8465b2';

        switch ($type) {
            case 'quotation_post':
                return $this->wp_api_post_eship($api, $api_key, $uri, $body);
            default:
                break;
        }
    }

    private function req_quotation_api_eship()
    {
        $eship_api = array(
            'address_from' => array(
                'name' => '',
                'company' => '',//optional
                'street1' => '',
                'street2' => '',//optional
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '',//ISO 2 country code
                'phone' => '',
                'email' => '',//optional
            ),
            'address_to' => array(
                'name' => '',
                'company' => '',//optional
                'street1' => '',
                'street2' => '',//optional
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '',//ISO 2 country code
                'phone' => '',
                'email' => '',//optional
            ),
            'parcels' => array(
                'length' => '',
                'width' => '',
                'height' => '',
                'distance_unit' => '',
                'weight' => '',
                'mass_unit' => '',
                'reference' => ''
            ),
            'items' => array(
                'quantity' => '',
                'description' => '',
                'SKU' => '',
                'price' => '',
                'weight' => '',
                'currency' => '',//“MXN”, “USD”
                'store_id' => ''
            ),
            'insurance' => array(
                'amount' => '',
                'currency' => ''//“MXN”, “USD”
            ),
            'order_info' => array(
                'order_num' => '',
                'paid' => '',
                'fulfilled' => '',
                'store' => '',
                'shipment' => '',
                'total_price' => '',
                'subtotal_price' => '',
                'total_tax' => '',
                'total_shipment' => '',
                'store_id' => ''
            ),
            'customs_declaration' => array(
                'contents_type' => '',
                'incoterm' => '',
                'exporter_reference' => '',
                'importer_reference' => '',
                'contents_explanation' => '',
                'invoice' => '',
                'license' => '',
                'certificate' => '',
                'notes' => '',
                'eel_pfc' => '',
                'non_delivery_option' => '',
                'certify' => '',
                'certify_signer' => '',
                'save_order' => '',
                'notes' => '',
            ),
        );
    }

    public function woocommerce_store_address_eship()
    {
        $res_wc_sg = $this->woocommerce_conn_eship('settings_general');
        $response = FALSE;
        $data     = array();
        if (is_array($res_wc_sg) && ! empty($res_wc_sg)) {
            foreach ($res_wc_sg as $key) {
                $new_arr = array(
                    'id'    => $key->id,
                    'value' => $key->value
                );

                array_push($data, $new_arr);
            }
        }

        if (! empty($data)) {
            $address_filter = function ($var){
                if ($var['id'] == 'woocommerce_store_address') return $var['value'];
            };

            $address2_filter = function ($var){
                if ($var['id'] == 'woocommerce_store_address_2') return $var['value'];
            };

            $city_filter = function ($var){
                if ($var['id'] == 'woocommerce_store_city') return $var['value'];
            };

            $country_iso_filter = array_filter(array_map(function ($var){
                if ($var['id'] == 'woocommerce_default_country') return $var['value'];
            }, $data));

            $countries   = $this->woocommerce_conn_eship('countries', FALSE, $country_iso_filter[3]);

            $zip_filter = function ($var){
                if ($var['id'] == 'woocommerce_store_postcode') return $var['value'];
            };

             $response = array(
                'address'   => array_filter(array_map($address_filter, $data)),
                'address2'  => array_filter(array_map($address2_filter, $data)),
                'city'      => array_filter(array_map($city_filter, $data)),
                'country'   => $countries,
                'zip'       => array_filter(array_map($zip_filter, $data))
            );
        }
         return $iso;
    }

    public function get_order_wc_eship($post, $section = FALSE) {
        $parameters = array(
            'id'    => $post
        );
        $result = $this->woocommerce_conn_eship('order_get', $parameters);

        return $result;
    }

    public function get_shipping_data_wc_eship($data) {
        $arr = array();
        foreach ($data as $key) {
            array_push($arr, $key->shipping);
        }
        return $arr;
    }


    public function get_shipping_lines_wc_eship($data) {
        $arr = array();
        foreach ($data as $key) {
            array_push($arr, $key->shipping_lines);
        }
        return $arr;
    }

    public function get_line_items_wc_eship($data) {
        $arr = array();
        foreach ($data as $key) {
            array_push($arr, $key->line_items);
        }
        return $arr;
    }

    public function get_product_data_wc_eship($id, $section) {
        $result = $this->woocommerce_conn_eship('product', $id);
        $response = FALSE;
        switch ($section) {
            case 'weight':
                //$response = $result
                return $result[0]->weight;
            case 'dimensions':
                return $result[0]->dimensions;
            default:
                return $result;
        }
        return $result;
    }
}