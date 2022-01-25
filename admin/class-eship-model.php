<?php
namespace EshipAdmin;

class ESHIP_Model {
    protected $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->tb = ESHIP_TB;
    }

    public function get_data_user_eship($show_data = FALSE)
    {
        $results = $this->db->get_results( "SELECT * FROM " . ESHIP_TB . ";", OBJECT );

        if ((count($results) > 0)) {

            switch ($show_data) {
                case 'name':
                    if (isset($results[0]->name) && !empty($results[0]->name)) {
                        return $results[0]->name;
                    } else  {
                        return  FALSE;
                    }
                case 'phone':
                    if (isset($results[0]->phone) && ! empty($results[0]->phone)) {
                         return $results[0]->phone;
                    } else {
                        return FALSE;
                    }
                case 'token':
                    if (isset($results[0]->token_eship) && !empty($results[0]->token_eship)) {
                        return $results[0]->token_eship;
                    } else  {
                        return  FALSE;
                    }
                case 'cs':
                    //test 'cs_fc047f331954ffa83623ed0f47c927afee406438';
                    //mac 'cs_46c0207837b87425d850fff14656ffef0621b4bc';
                    if (isset($results[0]->consumer_secret) && !empty($results[0]->consumer_secret)) {
                        return $results[0]->consumer_secret;
                    } else {
                        return FALSE;
                    }
                case 'ck':
                    //test 'ck_e1e2f573ca6d3237a02a7442952fa37806ef47ea';
                    //mac 'ck_8fc0c1a4fbc9fd2137a6b75c2728908f9346eb15';
                    if (isset($results[0]->consumer_key) && !empty($results[0]->consumer_key)){
                        return $results[0]->consumer_key;
                    } else  {
                        return FALSE;
                    }

                default:
                    if (isset($results) && count($results) > 0) {
                        return $results;
                    } else  {
                        return FALSE;
                    }
            }
        }
    }

    public function insert_data_store_eship($data)
    {
        $result = FALSE;
        if(current_user_can('manage_options')) {
            $adm = wp_get_current_user();
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'add_token') {
                $columns = [
                    'email'             => $adm->user_email,
                    'token_eship'       => $token,
                    'consumer_secret'   => $cs,
                    'consumer_key'      => $ck,
                    'name'              => $name,
                    'phone'             => $phone
                ];

                $format = [
                    "%s",
                    "%s",
                    "%s",
                    "%s",
                    "%s",
                    "%s"
                ];
                $result = $this->db->insert(ESHIP_TB, $columns, $format);

            }
        }

        return $result;
    }
}