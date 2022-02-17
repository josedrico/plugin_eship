<?php
namespace EshipAdmin;

use EshipAdmin\ESHIP_Model;
use EshipAdmin\ESHIP_Woocommerce_Api;
use EshipAdmin\ESHIP_Api;
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
            'name'      => ($tb->get_data_user_eship('name') != NULL)? $tb->get_data_user_eship('name') : $data['name'],
            'company'   => (isset($data['company']))? $data['company'] : '', //optional
            'street1'   => (isset($data['address']))? $data['address'] : '',
            'street2'   => (isset($data['address2']))? $data['address2'] : '', //optional
            'city'      => (isset($data['city']))? $data['city'] : '',
            'zip'       => (isset($data['zip']))? $data['zip'] : '',
            'state'     => (isset($data['state']))? $data['state'] : '',
            'country'   => (isset($data['country']))? $data['country'] : '', //ISO 2 country code
            'phone'     => ($tb->get_data_user_eship('phone'))? $tb->get_data_user_eship('phone') : '',//$data['phone'],
            'email'     => ($tb->get_data_user_eship('email'))? $tb->get_data_user_eship('email') : ''
        );

        return $data;
    }

    private function setAddressTo($data)
    {
        $data = array(
            'name'      => (isset($data->first_name) && isset($data->last_name))? $data->first_name . " " . $data->last_name : '',
            'company'   => (isset($data->company))? $data->company : '', //optional
            'street1'   => (isset($data->address_1))? $data->address_1 : '',
            'street2'   => (isset($data->address_2))? $data->address_2 : '', //optional
            'city'      => (isset($data->city))? $data->city : '',
            'zip'       => (isset($data->postcode))? $data->postcode : '',
            'state'     => (isset($data->state))? $data->state : '',
            'country'   => (isset($data->country))? $data->country : '', //ISO 2 country code
            'phone'     => (isset($data->phone))? $data->phone : '',
            'email'     => (isset($data->email))? $data->email : '' , //optional
        );

        return $data;
    }

    private function setParcels($data)
    {
        $parcels   = array();
        $data_gral = $this->woocommerce_api->getGeneral();


        $data_gral  = json_decode($data_gral);
        $tb         = new ESHIP_Model();
        $dim_active = $tb->get_data_user_eship('dimension');
        $dim_qry    = $tb->get_dimensions_eship();

        foreach ($data as $key) {
            $product = $this->woocommerce_api->getProductApi($key->product_id);

            if ($dim_active == 0 && $dim_qry) {
                $dimensions = array(
                    'length'        => (isset($dim_qry[0]->length_dim))? $dim_qry[0]->length_dim : '',
                    'width'         => (isset($dim_qry[0]->width_dim))? $dim_qry[0]->width_dim : '',
                    'height'        => (isset($dim_qry[0]->height_dim))? $dim_qry[0]->height_dim : '',
                    'distance_unit' => (isset($dim_qry[0]->unit_dim))? $dim_qry[0]->unit_dim : '',
                    'weight'        => (isset($dim_qry[0]->weight_w))? $dim_qry[0]->weight_w : '',
                    'mass_unit'     => (isset($dim_qry[0]->unit_w))? $dim_qry[0]->unit_w : '',
                    'reference'     => ''//
                );
            } else {
                $dimensions = array(
                    'length'        => $product['dimensions']->length,
                    'width'         => $product['dimensions']->width,
                    'height'        => $product['dimensions']->height,
                    'distance_unit' => $data_gral->dimension_unit,
                    'weight'        => $product['weight'],
                    'mass_unit'     => $data_gral->weight_unit,
                    'reference'     => ''//
                );
            }

            array_push($parcels, $dimensions);
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
                'quantity'      => (isset($key->quantity))? $key->quantity : '',
                'description'   => (isset($key->name))? $key->name : '',
                'SKU'           => (isset($key->sku))? $key->sku : '',
                'price'         => (isset($key->price))? $key->price : '',
                'weight'        => (isset($product['weight']))? $product['weight'] : '',
                'currency'      => (isset($data_gral->currency_code))? $data_gral->currency_code : '',//$key->currency, //“MXN”, “USD”
                'store_id'      => (isset($product['id']))? $product['id'] : ''//$key->store_id
            ));
        }

        return $items;
    }

    private function setOrderInfo($data)
    {
        $method_title = 'FLAT';
        $total = 0;
        if (!empty($data->shippings_lines)) {
            $method_title = $data->shippings_lines[0]->method_title;
        }

        $arr = array(
            'order_num'         => (isset($data->number))? $data->number : '',
            'paid'              => ($data->status != 'pending')? TRUE : FALSE,
            'fulfilled'         => FALSE,
            'store'             => 'woo',
            'shipment'          => $method_title,//$data->shipping_lines,
            'total_price'       => $data->total,
            'subtotal_price'    => ((float)$data->total - (float)$data->total_tax),
            'total_tax'         => $data->total_tax,
            'total_shipment'    => $data->shipping_total,
            'store_id'          => $data->id,
        );

        return $arr;
    }

    public function create($id)
    {
        try {
            $address_store      = $this->woocommerce_api->getStoreAddressApi();
            $eship_address_store = $this->setAddressFrom($address_store);
            $order              = $this->woocommerce_api->getOrderApi($id);
            $address_shipping   = $order->shipping;
            $eship_address_shipping = $this->setAddressTo($address_shipping);
            $line_items         = $order->line_items;
            $eship_line_items   = $this->setItems($line_items);
            $eship_parcels      = $this->setParcels($line_items);
            $body = array();

            array_push($body, array(
                'address_from'  => $eship_address_store,
                'address_to'    => $eship_address_shipping,
                'order_info'    => $this->setOrderInfo($order),
                'items'         => $eship_line_items,
                'parcels'       => $eship_parcels
            ));

            $json = json_encode($body[0]);

            return wp_remote_retrieve_body($this->eship_api->post('quotation', $json));

        } catch (\Exception $e) {
            return json_encode( array(
                'error'     => TRUE,
                'result'    => 'Create Quotation',
                'message'   => $e->getMessage()
            ));
        }
    }
}
