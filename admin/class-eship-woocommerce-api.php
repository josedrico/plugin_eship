<?php
namespace EshipAdmin;
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/BasicAuth.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/OAuth.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Options.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Request.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/Response.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClientException.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/HttpClient/HttpClient.php";
require_once ESHIP_PLUGIN_DIR_PATH . "helpers/wc-api/src/WooCommerce/Client.php";

use Automattic\WooCommerce\Client;

class ESHIP_Woocommerce_Api {
    private $url;
    private $consumer_key;
    private $consumer_secret;
    private $wp_api;
    private $version_api;
    public $woocommerce;

    public function __construct()
    {
        $this->setUrlApi();
        $this->setConsumerKey();
        $this->setConsumerSecret();
        $this->setWpApi();
        $this->setVersionApi();
        $this->setWoocommerce();
    }

    private function setUrlApi()
    {
        //$this->url = 'http://18.191.235.204/wp-plugin-eship';
        //$this->url              = 'http://wp.eship.mylocal:8888';
        $this->url = get_site_url();
    }

    public function getUrlApi()
    {
        return $this->url;
    }

    private function setConsumerKey()
    {
        //$this->consumer_key = 'ck_e1e2f573ca6d3237a02a7442952fa37806ef47ea';
        $this->consumer_key     = 'ck_8fc0c1a4fbc9fd2137a6b75c2728908f9346eb15';
    }

    private function getConsumerKey()
    {
        return $this->consumer_key;
    }

    private  function  setConsumerSecret()
    {
        //$this->consumer_secret = 'cs_fc047f331954ffa83623ed0f47c927afee406438';
        $this->consumer_secret = 'cs_46c0207837b87425d850fff14656ffef0621b4bc';
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
        $parameters = array(
            'id' => $id
        );
        $order = $this->woocommerce->get('orders', $parameters);
        if (! empty($order)) {
            $i = 0;
            $data = array();
            while($i < count($order)) {
                $new_order = array(
                    'id'                    => $order[$i]->id,
                    'status'                => (! empty($order[$i]->status) )? trim($order[$i]->status) : FALSE,
                    'currency'              => (! empty($order[$i]->currency) )? trim($order[$i]->currency) : FALSE,
                    'prices_include_tax'    => (! empty($order[$i]->prices_include_tax) )? trim($order[$i]->prices_include_tax) : FALSE,
                    'date_created'          => (! empty($order[$i]->date_created) )? trim($order[$i]->date_created) : FALSE,
                    'date_modified'         => (! empty($order[$i]->date_modified) )? trim($order[$i]->date_modified) : FALSE,
                    'discount_total'        => (! empty($order[$i]->discount_total) )? trim($order[$i]->discount_total) : FALSE,
                    'discount_tax'          => (! empty($order[$i]->discount_tax) )? trim($order[$i]->discount_tax) : FALSE,
                    'shipping_total'        => (! empty($order[$i]->shipping_total) )? trim($order[$i]->shipping_total) : FALSE,
                    'shipping_tax'          => (! empty($order[$i]->shipping_tax) )? trim($order[$i]->shipping_tax) : FALSE,
                    'cart_tax'              => (! empty($order[$i]->cart_tax) )? trim($order[$i]->cart_tax) : FALSE,
                    'total'                 => (! empty($order[$i]->total) )? trim($order[$i]->total) : FALSE,
                    'total_tax'             => (! empty($order[$i]->total_tax) )? trim($order[$i]->total_tax) : FALSE,
                    'customer_id'           => (! empty($order[$i]->customer_id) )? trim($order[$i]->customer_id) : FALSE,
                    'order_key'             => (! empty($order[$i]->order_key) )? trim($order[$i]->order_key) : FALSE,
                    'shipping'              => (! empty($order[$i]->shipping) )? $order[$i]->shipping : FALSE,
                    'customer_note'         => (! empty($order[$i]->customer_note) )? trim( htmlentities($order[$i]->customer_note) ) : FALSE,
                    'meta_data'             => (! empty($order[$i]->meta_data) )? $order[$i]->meta_data : FALSE,
                    'line_items'            => (! empty($order[$i]->line_items) )? $order[$i]->line_items : FALSE,
                    //'tax_lines' => (! empty($order[$i]->tax_lines) )? trim($order[$i]->tax_lines) : FALSE,
                    'shipping_lines'        => (! empty($order[$i]->shipping_lines) )? $order[$i]->shipping_lines : FALSE,
                    //'fee_lines' => (! empty($order[$i]->fee_lines) )? $order[$i]->fee_lines : FALSE,
                    //'coupon_lines' => (! empty($order[$i]->coupon_lines) )? $order[$i]->coupon_lines : FALSE,
                    //'refunds'               => (! empty($order[$i]->refunds) )? $order[$i]->refunds : FALSE,
                );
                array_push($data, $new_order);
                //$data = $order[$i];
                $i++;
            }
            return (( !empty($data) )? $data : FALSE);
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

    public function getStoreAddressApi() {
        $address    = $this->woocommerce->get('settings/general/woocommerce_store_address');
        $address2   = $this->woocommerce->get('settings/general/woocommerce_store_address_2');
        $city       = $this->woocommerce->get('settings/general/woocommerce_store_city');
        $country    = $this->woocommerce->get('settings/general/woocommerce_default_country');
        $zip        = $this->woocommerce->get('settings/general/woocommerce_store_postcode');

        if (! empty($country) && isset($country->value)) {
            $countries = $this->getCountryApi($country->value);
        }

        $result = array(
            'address'   => (isset($address->value) && !empty($address->value) )? $address->value : FALSE,
            'address2'  => (isset($address2->value) && !empty($address2->value) )? $address2->value : FALSE,
            'city'      => (isset($city->value) && !empty($city->value) )? $city->value : FALSE,
            'country'   => (isset($countries[0]['country_code']) )? $countries[0]['country_code'] : FALSE,
            'state'     => (isset($countries[0]['state_code']) )? $countries[0]['state_code'] : FALSE,
            'zip'       => (isset($zip->value) && !empty($zip->value) )? $zip->value : FALSE
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
}