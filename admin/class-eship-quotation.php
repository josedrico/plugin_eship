<?php
namespace EshipAdmin;

/**
 * Class that controls quotes.
 *
 * @since      1.0.0
 * @package    ESHIP
 * @author     juanmaleal
 *
 * @property string $woocommerce_api
 * @property string $eship_api
 */

use EshipAdmin\ESHIP_Model;
use EshipAdmin\ESHIP_Woocommerce_Api;
use EshipAdmin\ESHIP_Api;
use EshipAdmin\ESHIP_Admin_Notices;

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

    private function setAddressTo($data, $shippings_lines = FALSE)
    {
        $mail = '';
        if (isset($data->email) && !empty($data->email)) {
            $mail = $data->email;
        } else {
            $mail = $shippings_lines->email;
        }

        $phone = '';
        if (isset($data->phone) && !empty($data->phone)) {
            $phone = $data->phone;
        } else {
            $phone = $shippings_lines->phone;
        }

        $name = '';
        if (isset($data->first_name) && !empty($data->first_name)) {
            $name = $data->first_name;
        } else {
            $name = $shippings_lines->first_name;
        }

        $last_name = '';
        if (isset($data->last_name) && !empty($data->last_name)) {
            $last_name = $data->last_name;
        } else {
            $last_name = $shippings_lines->last_name;
        }

        $company = '';
        if (isset($data->company) && !empty($data->company)) {
            $company = $data->company;
        } else {
            $company = $shippings_lines->company;
        }

        $address_1 = '';
        if (isset($data->address_1) && !empty($data->address_1)) {
            $address_1 = $data->address_1;
        } else {
            $address_1 = $shippings_lines->address_1;
        }

        $address_2 = '';
        if (isset($data->address_2) && !empty($data->address_2)) {
            $address_2 = $data->address_2;
        } else {
            $address_2 = $shippings_lines->address_2;
        }


        $city = '';
        if (isset($data->city) && !empty($data->city)) {
            $city = $data->city;
        } else {
            $city = $shippings_lines->city;
        }

        $postcode = '';
        if (isset($data->postcode) && !empty($data->postcode)) {
            $postcode = $data->postcode;
        } else {
            $postcode = $shippings_lines->postcode;
        }

        $state = '';
        if (isset($data->state) && !empty($data->state)) {
            $state = $data->state;
        } else {
            $state = $shippings_lines->state;
        }

        $country = '';
        if (isset($data->country) && !empty($data->country)) {
            $country = $data->country;
        } else {
            $country = $shippings_lines->country;
        }

        $data = array(
            'name'      => $name . ' ' . $last_name,
            'company'   => $company, //optional
            'street1'   => $address_1,
            'street2'   => $address_2, //optional
            'city'      => $city,
            'zip'       => $postcode,
            'state'     => $state,
            'country'   => $country, //ISO 2 country code
            'phone'     => $phone,
            'email'     => $mail //optional
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

        if ($dim_active == 0 && $dim_qry[0]->status == 0) {
            $dimensions = array(
                'length'        => $dim_qry[0]->length_dim,
                'width'         => $dim_qry[0]->width_dim,
                'height'        => $dim_qry[0]->height_dim,
                'distance_unit' => $dim_qry[0]->unit_dim,
                'weight'        => $dim_qry[0]->weight_w,
                'mass_unit'     => $dim_qry[0]->unit_w,
                'reference'     => ''//
            );
            array_push($parcels, $dimensions);
        } else {

            foreach ($data as $key) {
                if ($dim_active == 0 && $dim_qry[0]->status == 1) {
                    $dimensions = array(
                        'length'        => $dim_qry[0]->length_dim,
                        'width'         => $dim_qry[0]->width_dim,
                        'height'        => $dim_qry[0]->height_dim,
                        'distance_unit' => $dim_qry[0]->unit_dim,
                        'weight'        => $dim_qry[0]->weight_w,
                        'mass_unit'     => $dim_qry[0]->unit_w,
                        'reference'     => ''//
                    );
                } else {
                    $product = $this->woocommerce_api->getProductApi($key->product_id);
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
            //'shipping'          => $data->shipping,
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

    public function create($id, $timeout = 45, $type_data = FALSE)
    {
        try {
            $order = $this->woocommerce_api->getOrderApi($id);

            if (isset($order['error']) && $order['error']) {
                return json_encode( array(
                    'error'   => TRUE,
                    'result'  => 'Create Quotation',
                    'message' => $order['message']
                ));
            } else {
                $address_store          = $this->woocommerce_api->getStoreAddressApi();
                $eship_address_store    = $this->setAddressFrom($address_store);
                $eship_address_shipping = $this->setAddressTo($order['result']->shipping, $order['result']->billing);
                $line_items             = $order['result']->line_items;
                $eship_line_items       = $this->setItems($line_items);
                $eship_parcels          = $this->setParcels($line_items);

                $body = array();
                array_push($body, array(
                    'address_from' => $eship_address_store,
                    'address_to'   => $eship_address_shipping,
                    'order_info'   => $this->setOrderInfo($order['result']),
                    'items'        => $eship_line_items,
                    'parcels'      => $eship_parcels
                ));
                if ($type_data) {
                    $res      = wp_remote_retrieve_body($this->eship_api->post('quotation', json_encode($body[0]), $timeout));
                    $res      = json_decode($res);
                    $data_res = array();
                    if ($order['error']) {
                        array_push($data_res, array(
                            'object_id'  => '',
                            'rates'      => [],
                            'date_final' => '',
                            'order_id'   => $id
                        ));
                    } else {
                        array_push($data_res, array(
                            'object_id'  => $res->object_id,
                            'rates'      => $res->rates,
                            'date_final' => (isset($order['result']->date_modified))? $order['result']->date_modified : $order['result']->date_created,
                            'order_id'   => $id
                        ));
                    }
                    return $data_res;
                } else {
                    $json = json_encode($body[0]);
                    return wp_remote_retrieve_body($this->eship_api->post('quotation', $json, $timeout));
                }

            }
        } catch (\Exception $e) {
            return json_encode( array(
                'error'     => TRUE,
                'result'    => 'Create Quotation',
                'message'   => $e->getMessage()
            ));
        }
    }
}
