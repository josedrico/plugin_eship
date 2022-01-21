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
                    return $results[0]->name;
                case 'phone':
                    return $results[0]->phone;
                case 'token':
                    return $results[0]->token_eship;
                case 'cs':
                    //test 'cs_fc047f331954ffa83623ed0f47c927afee406438';
                    //mac 'cs_46c0207837b87425d850fff14656ffef0621b4bc';
                    return $results[0]->consumer_secret;
                case 'ck':
                    //test 'ck_e1e2f573ca6d3237a02a7442952fa37806ef47ea';
                    //mac 'ck_8fc0c1a4fbc9fd2137a6b75c2728908f9346eb15';
                    return $results[0]->consumer_key;
                default:
                    return $results;

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