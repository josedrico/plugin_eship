<?php
namespace EshipAdmin;
require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-woocommerce-api.php';
require_once ESHIP_PLUGIN_DIR_PATH . 'admin/class-eship-api.php';

use EshipAdmin\ESHIP_Woocommerce_Api;
use EshipAdmin\ESHIP_Api;

/**
 * Config and queries to api's.
 *
 * @link       https://eship.com
 * @since      1.0.0
 *
 * @package    ESHIP_blank
 * @subpackage ESHIP_blank/admin
 */

class ESHIP_Quotation {
    private $woocommerce_api;
    private $eship_api;

    public function __construct()
    {
        $this->woocommerce_api  = new ESHIP_Woocommerce_Api();
        $this->eship_api        = new ESHIP_Api();
    }

    private function quotation_api_eship($type, $uri, $body)
    {
        $api        = "https://api.myeship.co/rest/";
        $api_key    = 'eship_prod_835261c341f8465b2';

        switch ($type) {
            case 'quotation_post':
                return $this->wp_api_post_eship($api, $api_key, $uri, $body);
            default:
                break;
        }
    }
    //mover arriba a clase eship api

    private function req_quotation_api_eship()
    {
        $eship_api = array(
            'address_from' => array(
                'name' => '',
                'company' => '', //optional
                'street1' => '',
                'street2' => '', //optional
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '', //ISO 2 country code
                'phone' => '',
                'email' => '', //optional
            ),
            'address_to' => array(
                'name' => '',
                'company' => '', //optional
                'street1' => '',
                'street2' => '', //optional
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '', //ISO 2 country code
                'phone' => '',
                'email' => '', //optional
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
                'currency' => '', //“MXN”, “USD”
                'store_id' => ''
            ),
            'insurance' => array(
                'amount' => '',
                'currency' => '' //“MXN”, “USD”
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

    public function create_quotation_api_eship()
    {
        $arr = array();
        if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
            $order          = $this->get_order_wc_eship($_GET['post']);
            $lines_items    = $this->get_line_items_wc_eship($order);
            $data           = array();

            if (is_array($lines_items[0])) {
                foreach ($lines_items[0] as $item) {
                    $weight     = $this->get_product_data_wc_eship($item->product_id, 'weight');
                    $dimensions = $this->get_product_data_wc_eship($item->product_id, 'dimensions');
                    array_push($data, array(
                        'product_id'    => $item->product_id,
                        'weight'        => $weight,
                        'dimensions'    => $dimensions
                    ));
                }
            }
            array_push($arr, array(
                'order'          => $this->get_order_wc_eship($_GET['post']),
                'shipping'       => $this->get_shipping_data_wc_eship($order),
                'shipping_lines' => $this->get_shipping_lines_wc_eship($order),
                'lines_items'    => $lines_items,
                'product_data'   => $data
            ));
        }
        return $this->woocommerce_api->getApiOrder($_GET['post']);
    }
}
