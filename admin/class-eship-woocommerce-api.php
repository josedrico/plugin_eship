<?php
namespace EshipAdmin;

use EshipAdmin\ESHIP_Model;
use Automattic\WooCommerce\Client;
use EshipAdmin\ESHIP_Admin_Notices;

class ESHIP_Woocommerce_Api {
    private $url;
    private $consumer_key;
    private $consumer_secret;
    private $wp_api;
    private $version_api;
    public $woocommerce;
    private $store;

    public function __construct()
    {
        global $blog_id;
        $this->store = $blog_id;
        $this->setUrlApi();
        $this->setConsumerKey();
        $this->setConsumerSecret();
        $this->setWpApi();
        $this->setVersionApi();
        $this->setWoocommerce();
    }

    private function setUrlApi()
    {
        $this->url = get_site_url();
    }

    public function getUrlApi()
    {
        return $this->url;
    }

    private function setConsumerKey()
    {
        $tb = new ESHIP_Model();
        $this->consumer_key = $tb->get_data_user_eship('ck');
    }

    private function getConsumerKey()
    {
        return $this->consumer_key;
    }

    private  function  setConsumerSecret()
    {
        $tb = new ESHIP_Model();
        $this->consumer_secret = $tb->get_data_user_eship('cs');
    }

    private function getConsumerSecret()
    {
        return $this->consumer_secret;
    }

    private function setWpApi()
    {
        $this->wp_api = TRUE;
    }

    public function getWpApi()
    {
        return $this->wp_api;
    }

    private function setVersionApi()
    {
        $this->version_api = 'wc/v3';
    }

    public function getVersionApi()
    {
        return $this->version_api;
    }

    private function setWoocommerce()
    {
        $this->woocommerce = new Client(
            $this->getUrlApi(),
            $this->getConsumerKey(),
            $this->getConsumerSecret(),
            [
                'wp_api'    => $this->getWpApi(),
                'version'   => $this->getVersionApi()
            ]
        );
    }

    public function getWoocommerce()
    {
        return $this->woocommerce;
    }

    public function getOrderApi($id)
    {
        try {
            $order = $this->woocommerce->get('orders/' . $id);
            if (! empty($order)) {
                return (( !empty($order) )? $order : FALSE);
            }
        } catch (\Exception $e) {
            return  array(
                'error'     => TRUE,
                'result'    => $e->getMessage()
            );
        }

    }

    public function getCountryApi($string)
    {
        $iso    = explode(':', $string);
        $result = $this->woocommerce->get('data/countries/' . $iso[0]);
        $data   = array();

        if (isset($result) && !empty($result)) {

            foreach ($result->states as $key) {
                if ($key->code == $iso[1]) {
                    $new_arr = array(
                        'country'       => $result->name,
                        'country_code'  => $result->code,
                        'state_code'    => $key->code,
                        'state'         => $key->name
                    );
                    array_push($data, $new_arr);
                }
            }
        }
        return $data;
    }

    public function getStoreAddressApi()
    {
        $address    = $this->woocommerce->get('settings/general/woocommerce_store_address');
        $address2   = $this->woocommerce->get('settings/general/woocommerce_store_address_2');
        $city       = $this->woocommerce->get('settings/general/woocommerce_store_city');
        $country    = $this->woocommerce->get('settings/general/woocommerce_default_country');
        $zip        = $this->woocommerce->get('settings/general/woocommerce_store_postcode');

        if (! empty($country) && isset($country->value)) {
            $countries = $this->getCountryApi($country->value);
        }

        $result = array(
            'name'      => (!empty(get_bloginfo()))? get_bloginfo() : '',
            'address'   => (isset($address->value) && !empty($address->value) )? $address->value : FALSE,
            'address2'  => (isset($address2->value) && !empty($address2->value) )? $address2->value : FALSE,
            'city'      => (isset($city->value) && !empty($city->value) )? $city->value : FALSE,
            'country'   => (isset($countries[0]['country_code']) )? $countries[0]['country_code'] : FALSE,
            'state'     => (isset($countries[0]['state_code']) )? $countries[0]['state_code'] : FALSE,
            'zip'       => (isset($zip->value) && !empty($zip->value) )? $zip->value : FALSE,
            'email'     => (!empty(get_option('admin_email')))? get_option('admin_email') : '',
            'company'   => (!empty(get_bloginfo()))? get_bloginfo() : ''
        );

        return $result;
    }

    public function getProductApi($id)
    {
        $product = $this->woocommerce->get('products/' . $id);
        return array(
            'product_id'        => $product->id,
            'name'              => (! empty($product->name))? trim(htmlentities($product->name)) : FALSE,
            'sku'               => (! empty($product->sku))? trim($product->sku) : FALSE,
            'price'             => (! empty($product->price))? trim($product->price) : FALSE,
            'regular_price'     => (! empty($product->regular_price))? trim($product->regular_price) : FALSE,
            'sale_price'        => (! empty($product->sale_price))? trim($product->sale_price) : FALSE,
            'description'       => (! empty($product->description))? trim(htmlentities($product->description)) : FALSE,
            'short_description' => (! empty($product->short_description))? trim(htmlentities($product->short_description)) : FALSE,
            'weight'            => (! empty($product->weight))? trim($product->weight) : FALSE,
            'dimensions'        => (! empty($product->dimensions))? $product->dimensions : FALSE,
            'shipping_required' => (! empty($product->shipping_required))? trim($product->shipping_required) : FALSE,
            'shipping_taxable'  => (! empty($product->shipping_taxable))? trim($product->shipping_taxable) : FALSE,
            'shipping_class'    => (! empty($product->shipping_class))? trim(htmlentities($product->shipping_class)) : FALSE,
            'shipping_class_id' => (! empty($product->shipping_class_id))? trim($product->shipping_class_id) : FALSE,
            'images'            => (! empty($product->images))? $product->images : FALSE,
            'variations'        => (! empty($product->variations) )? $product->variations : FALSE,
        );
    }

    public function test()
    {
        return  $this->woocommerce->get('');
    }

    public function getGeneral() {
        $result = $this->woocommerce->get('data/continents');
        $north_america = $result[4];
        $data = array();
        foreach ($north_america->countries  as $key) {
            //var_dump($key->code);
            if ($key->code == 'MX'){
                //var_dump($key);
                array_push($data, $key);
            }
            /*
            if ($key->code == 'US'){
                //var_dump($key);
                array_push($data, $key);
            }
            */
        }
        $result = json_encode($data[0]);
        return $result;
    }
}