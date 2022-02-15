<?php

namespace EshipAdmin;

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
class ESHIP_Shipment {
    private $rate_id;
    private $eship_api;
    private $multiple;

    public function __construct($rate_id, $multiple = FALSE)
    {
        $this->eship_api = new ESHIP_Api();
        $this->rate_id   = $rate_id;
        $this->multiple  = $multiple;
    }

    public function getShipment()
    {
        try {
            $uri = 'shipment';
            $timeout = 50;
            $json = json_encode(array(
                'rate'  => $this->rate_id
            ));

            if ($this->multiple) {
                $uri = 'batch_shipment';
                $timeout = 100;
                $json = json_encode(array(
                    'rates' => $this->rate_id
                ));
            }

            $response = wp_remote_retrieve_body($this->eship_api->post($uri, $json, $timeout));

        } catch (\Exception $e) {
            $response = array(
                'error'     => TRUE,
                'result'    => $e->getMessage()
            );
        }
        return $response;
    }
}