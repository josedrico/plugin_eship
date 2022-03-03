<?php
namespace EshipAdmin;

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
                    if (isset($results[0]->api_key_eship) && !empty($results[0]->api_key_eship)) {
                        return $results[0]->api_key_eship;
                    } else  {
                        return  FALSE;
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

                case 'email':
                    if (isset($results[0]->email)) {
                        return $results[0]->email;
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
            //$adm = wp_get_current_user();
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'add_token') {

                $columns = [
                    'dimensions'        => (int)$dimensions,
                    'email'             => $email,//$adm->user_email,
                    'name'              => $name,
                    'phone'             => $phone,
                    'api_key_eship'     => $token,
                ];

                $format = [
                    "%d",
                    "%s",
                    "%s",
                    "%s",
                    "%s"
                ];
                $result = $this->db->insert(ESHIP_TB, $columns, $format);
            }
        }

        return $data;//$result;
    }

    public function update_data_store_eship($data)
    {
        $result = FALSE;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'update_token') {

                $result = $this->db->update(ESHIP_TB,
                    array(
                        'api_key_eship'     => sanitize_text_field($token),
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
                        '%s'
                    ),
                    array('%d')
                );

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
                    'status'        => 1,
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
                    ['status' => $status],
                    ['id' => $dimId]
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