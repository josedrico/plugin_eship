<?php
namespace EshipAdmin;

use Cassandra\Date;

class ESHIP_Model {
    protected $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
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
                case 'dimension':
                    if (isset($results[0]->dimensions) && !empty($results[0]->dimensions)){
                        return $results[0]->dimensions;
                    } else  {
                        return FALSE;
                    }

                case 'id':
                    if (isset($results[0]->id)) {
                        return $results[0]->id;
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
                    'phone'             => $phone,
                    'dimensions'        => $dimensions
                ];

                $format = [
                    "%s",
                    "%s",
                    "%s",
                    "%s",
                    "%s",
                    "%s",
                    "%d"
                ];
                $result = $this->db->insert(ESHIP_TB, $columns, $format);

            }
        }

        return $result;
    }

    public function update_data_store_eship($data)
    {
        $result = FALSE;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'update_token') {

                $result = $this->db->update(ESHIP_TB,
                    array(
                        'token_eship'       => sanitize_text_field($token),
                        'consumer_key'      => sanitize_text_field($ck),
                        'consumer_secret'   => sanitize_text_field($cs),
                        'phone'             => sanitize_text_field($phone),
                        'name'              => sanitize_text_field($name),
                        'email'             => sanitize_email($email),
                        'dimensions'        => sanitize_text_field($dimensions)
                    ),
                    array(
                        'id' => $user
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    ),
                    array('%d')
                );

                if($result > 0){
                    $result = $this->db->last_query();
                }
                $this->db->flush();
            }

            if ($typeAction == 'update_dimension_token') {
                $result = $this->db->update(ESHIP_TB,
                    array(
                        'dimensions' => $dimensions
                    ),
                    array(
                        'id' => $id
                    ),
                    array(
                        '%s'
                    ),
                    array('%d')
                );

                $this->db->flush();
            }

            if ($typeAction == 'update_dimension_value') {
                $result = $this->db->update(ESHIP_TB,
                    array(
                        'dimensions' => $dimVal
                    ),
                    array(
                        'id' => $dim_id
                    ),
                    array(
                        '%s'
                    ),
                    array('%d')
                );

                $this->db->flush();
            }
        }

        return $result;
    }

    public function get_dimensions_eship()
    {
        $results = $this->db->get_results( "SELECT * FROM " . ESHIP_TB_DIM . ";", OBJECT );

        if (isset($results) && (count($results) > 0)) {
            return $results;
        } else {
            return FALSE;
        }
    }

    public function insert_dimensions_eship($data)
    {
        $result = FALSE;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);
            date_default_timezone_set('America/Mexico_City');
            $date_timestamp = new \DateTime();

            if ($typeAction == 'add_dimensions') {
                $columns = [
                    'name'          => $aliasEship,
                    'length_dim'    => (float)$lengthEship,
                    'width_dim'     => (float)$widthEship,
                    'height_dim'    => (float)$heightEship,
                    'unit_dim'      => $unitDimensionsEship,
                    'weight_w'      => (float)$weightEship,
                    'unit_w'        => $unitWeigthEship,
                    'status'        => ($statusEship == 'true')? 1 : 0,
                    'created_at'    => $date_timestamp->format('Y-m-d H:i:s')
                ];

                $format = [
                    "%s",
                    "%f",
                    "%f",
                    "%f",
                    "%s",
                    "%f",
                    "%s",
                    "%d",
                    "%s",
                ];
                $result = $this->db->insert(ESHIP_TB_DIM, $columns, $format);

            }
        }

        return $result;
    }

    public function update_dimension_eship($data)
    {
        $result = 0;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'update_status_dimension') {

                $result = $this->db->update(
                    ESHIP_TB_DIM,
                    array('status' => $status),
                    array('id' => $dim)
                );

                $this->db->flush();
            }

            if ($typeAction == 'update_dimensions') {
                date_default_timezone_set('America/Mexico_City');
                $date_timestamp = new \DateTime();
                $result = $this->db->update(
                    ESHIP_TB_DIM,
                    array(
                        'name'          => $aliasEship,
                        'length_dim'    => (float)$lengthEship,
                        'width_dim'     => (float)$widthEship,
                        'height_dim'    => (float)$heightEship,
                        'unit_dim'      => $unitDimensionsEship,
                        'weight_w'      => (float)$weightEship,
                        'unit_w'        => $unitWeigthEship,
                        'status'        => $statusEship,
                        'created_at'    => $date_timestamp->format('Y-m-d H:i:s')
                    ),
                    array('id' => $dim)
                );

                $this->db->flush();
            }
        }

        return $result;
    }

    public function delete_dimension_eship($data)
    {
        $result = 0;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'delete_dimension') {

                $result = $this->db->delete(
                    ESHIP_TB_DIM,
                    array('id' => $delId),
                    array('%d')
                );
            }
        }

        return $result;
    }
}