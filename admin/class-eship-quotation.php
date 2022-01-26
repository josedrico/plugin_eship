<?php
namespace EshipAdmin;

use EshipAdmin\ESHIP_Woocommerce_Api;
use EshipAdmin\ESHIP_Api;
use EshipAdmin\ESHIP_Model;
use EshipAdmin\ESHIP_Admin_Notices;

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

    private function setAddressFrom($data)
    {
        $tb = new ESHIP_Model();
        $data = array(
            'name'      => $tb->get_data_user_eship('name'),//$data['name'],
            'company'   => $data['company'], //optional
            'street1'   => $data['address'],
            'street2'   => $data['address2'], //optional
            'city'      => $data['city'],
            'zip'       => $data['zip'],
            'state'     => $data['state'],
            'country'   => $data['country'], //ISO 2 country code
            'phone'     => $tb->get_data_user_eship('phone'),//$data['phone'],
            'email'     => $data['email'], //optional
        );

        return $data;
    }

    private function setAddressTo($data)
    {
        $data = array(
            'name'      => $data->first_name . " " . $data->last_name,
            'company'   => (isset($data->company))? $data->company : '', //optional
            'street1'   => $data->address_1,
            'street2'   => (isset($data->address_2))? $data->address_2 : '', //optional
            'city'      => $data->city,
            'zip'       => $data->postcode,
            'state'     => $data->state,
            'country'   => $data->country, //ISO 2 country code
            'phone'     => $data->phone,
            'email'     => (isset($data->email))? $data->email : '' , //optional
        );

        return $data;
    }

    private function setParcels($data)
    {
        $parcels = array();
        $data_gral = $this->woocommerce_api->getGeneral();
        $data_gral = json_decode($data_gral);

        foreach ($data as $key) {
            $product = $this->woocommerce_api->getProductApi($key->product_id);
            array_push($parcels, array(
                'length'        => $product['dimensions']->length,
                'width'         => $product['dimensions']->width,
                'height'        => $product['dimensions']->height,
                'distance_unit' => $data_gral->dimension_unit,//'cm'
                'weight'        => $product['weight'],
                'mass_unit'     => $data_gral->weight_unit,
                'reference'     => 'reference'//
            ));
        }
        return $parcels;
    }

    private function setInsurance($data) {
        return array(
            "amount"    => $data['amount'],
            "currency"  => $data['currency']
        );
    }

    private function setItems($data) {
        $items      = array();
        $data_gral  = $this->woocommerce_api->getGeneral();
        $data_gral  = json_decode($data_gral);

        foreach ($data as $key) {
            $product = $this->woocommerce_api->getProductApi($key->product_id);
            array_push($items, array(
                'quantity'      => $key->quantity,
                'description'   => $key->name,
                'SKU'           => $key->sku,
                'price'         => $key->price,
                'weight'        => $product['weight'],
                'currency'      => $data_gral->currency_code,//$key->currency, //“MXN”, “USD”
                'store_id'      => $product['id']//$key->store_id
            ));
        }

        return $items;
    }

    private function setOrderInfo($data)
    {
        $arr = array();

        array_push($arr,  array(
            'order_num'         => $data->number,
            'paid'              => ($data->status == 'completed')? TRUE : FALSE,
            'fulfilled'         => FALSE,
            'store'             => 'woo',
            'shipment'          => $data->shipping_lines,
            'total_price'       => $data->total,
            'subtotal_price'    => ((float)$data->total - (float)$data->total_tax),
            'total_tax'         => $data->total_tax,
            'total_shipment'    => $data->shipping_total,
            'store_id'          => $data->id,
        ));

        return $arr;
    }

    public function create($id)
    {
        try {
            $address_store          = $this->woocommerce_api->getStoreAddressApi();
            $eship_address_store    = $this->setAddressFrom($address_store);
            $order                  = $this->woocommerce_api->getOrderApi($id);
            $address_shipping       = $order->shipping;
            $eship_address_shipping = $this->setAddressTo($address_shipping);
            $line_items             = $order->line_items;
            $eship_line_items       = $this->setItems($line_items);
            $eship_parcels          = $this->setParcels($line_items);
            $body                   = array();

            array_push($body, array(
                'address_from'  => $eship_address_store,
                'address_to'    => $eship_address_shipping,
                'order_info'    => $this->setOrderInfo($order),
                'items'         => $eship_line_items,
                'parcels'       => $eship_parcels
            ));

            $json       = json_encode($body[0]);
            $response  = wp_remote_retrieve_body($this->eship_api->post('quotation', $json));
            //var_dump($response);
            //die();
        } catch (\Exception $e) {
            $response = wp_remote_retrieve_body( array(
                'error'     => TRUE,
                'result'    => $e->getMessage()
            ));
        }

        return $response;
    }
}
