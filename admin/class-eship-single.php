<?php
namespace EshipAdmin;

use EshipAdmin\ESHIP_Quotation;
use EshipAdmin\ESHIP_Shipment;

class Eship_Single {
    private $order;

    public function __construct($order)
    {
        $this->order = $order;
        $this->eship_quotation  = new ESHIP_Quotation();
        $this->eship_shipment   = new ESHIP_Shipment();
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function _validate_data()
    {

    }

    public function getQuotation($data)
    {
        $result = $this->eship_quotation->create($data);

    }

    public function shipment($data)
    {

    }

    public function run () {

    }

    public function response($data, $test = FALSE)
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