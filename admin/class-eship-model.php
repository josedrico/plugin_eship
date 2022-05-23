<?php
namespace EshipAdmin;
/**
 * Class for the model for the wordpress database
 *
 * @since      1.0.0
 * @package    ESHIP
 * @author     juanmaleal
 *
 * @property string $db
 */

class ESHIP_Model {
    protected $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function get_data_user_eship($show_data = FALSE)
    {
        $results = $this->db->get_results($this->db->prepare( "SELECT * FROM " . ESHIP_TB . ";"), OBJECT );

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
                case 'ck':
                    if (isset($results[0]->ck)) {
                        return $results[0]->ck;
                    } else  {
                        return FALSE;
                    }
                case 'cs':
                    if (isset($results[0]->cs)) {
                        return $results[0]->cs;
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
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'add_token') {

                $columns = [
                    'dimensions'    => sanitize_text_field((int)$dimensions),
                    'email'         => sanitize_email($email),
                    'name'          => sanitize_text_field(strtoupper($name)),
                    'phone'         => sanitize_text_field($phone),
                    'api_key_eship' => sanitize_text_field($token),
                    'cs'            => sanitize_text_field($cs),
                    'ck'            => sanitize_text_field($ck)
                ];

                $format = [
                    "%d",
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
                        'api_key_eship' => sanitize_text_field($token),
                        'phone'         => sanitize_text_field($phone),
                        'name'          => sanitize_text_field(strtoupper($name)),
                        'email'         => sanitize_email($email),
                        'dimensions'    => sanitize_text_field($dimensions),
                        'cs'            => sanitize_text_field($cs),
                        'ck'            => sanitize_text_field($ck),
                    ),
                    array(
                        'id' => sanitize_text_field($user)
                    ),
                    array(
                        '%s',
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
                        'dimensions' => sanitize_text_field($dimensions)
                    ),
                    array(
                        'id' => sanitize_text_field($id)
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
                        'dimensions' => sanitize_text_field($dimVal)
                    ),
                    array(
                        'id' => sanitize_text_field($dim_id)
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
        $results = $this->db->get_results( $this->db->prepare("SELECT * FROM " . ESHIP_TB_DIM . ";"), OBJECT );

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
            $date_timestamp = new \DateTime();

            if ($typeAction == 'add_dimensions') {
                $columns = [
                    'name'          => sanitize_text_field(strtoupper($aliasEship)),
                    'length_dim'    => sanitize_text_field((float)$lengthEship),
                    'width_dim'     => sanitize_text_field((float)$widthEship),
                    'height_dim'    => sanitize_text_field((float)$heightEship),
                    'unit_dim'      => sanitize_text_field($unitDimensionsEship),
                    'weight_w'      => sanitize_text_field((float)$weightEship),
                    'unit_w'        => sanitize_text_field($unitWeigthEship),
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

    public function update_dimensions_eship($data)
    {
        $result = 0;
        if(current_user_can('manage_options')) {
            extract($data, EXTR_OVERWRITE);

            if ($typeAction == 'update_status_dimension') {
                $id_dim     = sanitize_text_field($dimId);
                $result     = $this->db->update(
                    ESHIP_TB_DIM,
                    ['status' => sanitize_text_field($status)],
                    ['id'     => $id_dim]
                );
                $this->db->flush();
            } else if ($typeAction == 'update_dimensions') {
                $date_timestamp = new \DateTime();
                $id_dim         = sanitize_text_field($dim);
                $result         = $this->db->update(
                    ESHIP_TB_DIM,
                    array(
                        'name'          => sanitize_text_field(strtoupper($aliasEship)),
                        'length_dim'    => sanitize_text_field((float)$lengthEship),
                        'width_dim'     => sanitize_text_field((float)$widthEship),
                        'height_dim'    => sanitize_text_field((float)$heightEship),
                        'unit_dim'      => sanitize_text_field($unitDimensionsEship),
                        'weight_w'      => sanitize_text_field((float)$weightEship),
                        'unit_w'        => sanitize_text_field($unitWeigthEship),
                        'created_at'    => $date_timestamp->format('Y-m-d H:i:s')
                    ),
                    array('id' => $id_dim)
                );

                $this->db->flush();
            }
        } else {
            $result = 2;
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
                    array('id' => sanitize_text_field($delId)),
                    array('%d')
                );
            }
        }

        return $result;
    }

    public function createColumnCk() {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . ESHIP_TB ."' AND column_name = 'ck'";
        $row = $this->db->get_results($sql);
        if (empty($row)) {
            return $this->db->query("ALTER TABLE " . ESHIP_TB . " ADD ck varchar(255) DEFAULT NULL");
        } else  {
            return FALSE;
        }
    }

    public function createColumnCs() {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . ESHIP_TB ."' AND column_name = 'cs'";
        $row = $this->db->get_results($sql);
        if (empty($row)) {
            return $this->db->query("ALTER TABLE " . ESHIP_TB . " ADD cs varchar(255) DEFAULT NULL");
        } else  {
            return FALSE;
        }
    }

    public function updateCk($data, $id) {
        $result = $this->db->update(ESHIP_TB,
            array(
                'ck' => sanitize_text_field($data)
            ),
            array(
                'id' => sanitize_text_field($id)
            ),
            array(
                '%s'
            ),
            array('%d')
        );

        $this->db->flush();
        
        if($result){
            return $result;
        } else {
            return FALSE;
        }
    }

    public function updateCs($data, $id) {
        $result = $this->db->update(ESHIP_TB,
            array(
                'cs' => sanitize_text_field($data)
            ),
            array(
                'id' => sanitize_text_field($id)
            ),
            array(
                '%s'
            ),
            array('%d')
        );
        $this->db->flush();

        if($result){
            return $result;
        } else {
            return FALSE;
        }
    }
}