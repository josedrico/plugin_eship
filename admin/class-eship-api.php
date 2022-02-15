<?php
namespace EshipAdmin;

use EshipAdmin\ESHIP_Model;
use EshipAdmin\ESHIP_Admin_Notices;

class ESHIP_Api {
    private $url;
    private $api_key;

    public function __construct()
    {
        $this->setUrl();
        $this->setApiKey();
    }

    private function setUrl()
    {
        $this->url = "https://api.myeship.co/rest/";
    }

    private function setApiKey()
    {
        $tb = new ESHIP_Model();
        $this->api_key = $tb->get_data_user_eship('token');
    }

    public function post($uri, $body, $timeout = 45)
    {
        return  wp_remote_post(
            $this->url . $uri,
            array(
                'method'      => 'POST',
                'timeout'     => $timeout,
                //'redirection' => 5,
                //'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'content-Type'  => 'Application/json',
                    'api-key'       => $this->api_key
                ),
                'body'      => $body,
                'cookies'   => array()
            )
        );
    }

    public function get($uri) {
        return wp_remote_get($this->url . $uri, array(
            'headers' => array(
                'content-Type'  => 'Application/json',
                'api-key'       => $this->api_key
            )
        ));
    }

    public function getCredentials($data = FALSE) {
        if ($data) {
            return wp_remote_get($this->url . 'credentials-woo', array(
                'headers' => array(
                    'content-Type'  => 'Application/json',
                    'api-key'       => $data
                )
            ));
        } else {
            return wp_remote_get($this->url . 'credentials-woo', array(
                'headers' => array(
                    'content-Type'  => 'Application/json',
                    'api-key'       => $this->api_key
                )
            ));
        }
    }
}