<?php
namespace EshipAdmin;

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
        $token = new \ESHIP_Model();
        //eship_prod_835261c341f8465b2
        $this->api_key = $token->get_data_user_eship('token');
    }

    public function post($uri, $body)
    {
        return wp_remote_post(
            $this->url . $uri,
            array(
                'method'      => 'POST',
                //'timeout'     => 45,
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
}