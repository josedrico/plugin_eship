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

    public function __construct($rate_id)
    {
        $this->eship_api    = new ESHIP_Api();
        $this->rate_id      = $rate_id;
    }

    public function getShipment()
    {
        try {
            $json       = json_encode(array(
                'rate'  => $this->rate_id
            ));
            $response   = wp_remote_retrieve_body($this->eship_api->post('shipment', $json));
        } catch (\Exception $e) {
            $response = array(
                'error'     => TRUE,
                'result'    => $e->getMessage()
            );
        }
        return $response;
    }
}