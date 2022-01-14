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

    public function create($id)
    {
        $address_store      = $this->woocommerce_api->getStoreAddressApi();
        $order              = $this->woocommerce_api->getOrderApi($id);
        $address_shipping   = $order[0]['shipping'];
        $line_items         = $order[0]['line_items'];
        //$shipping_lines     = $order[0]['shipping_lines'];
        $products           = $this->woocommerce_api->getProductApi($line_items[0]->product_id);
        $weigth             = $products['weight'];
        $dimensions         = $products['dimensions'];

        return $address_store;
    }
}
