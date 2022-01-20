<?php

namespace EshipAdmin;

use EshipAdmin\ESHIP_Api;
use EshipAdmin\ESHIP_Woocommerce_Api;

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
    //private $woocommerce_api;
    private $eship_api;

    public function __construct($rate_id)
    {
        $this->rate_id = $rate_id;
        //$this->woocommerce_api  = new ESHIP_Woocommerce_Api();
        $this->eship_api        = new ESHIP_Api();
    }

    public function getShipment()
    {
        $json       = json_encode(array(
            'rate'  => $this->rate_id
        ));
        $response   = wp_remote_retrieve_body( $this->eship_api->post('shipment', $json) );
        return $response;
    }
}