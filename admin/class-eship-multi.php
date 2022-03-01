<?php

namespace EshipAdmin;

class Eship_Multi {
    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function _validate_data()
    {

    }

    public function quotation($data)
    {

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