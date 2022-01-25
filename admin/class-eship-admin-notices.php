<?php
namespace EshipAdmin;
/**
 * Ésta clase define los mensajes de error para el administrador
 *
 * @since      1.0.0
 * @package    ESHIP
 * @subpackage ESHIP/includes
 * @author     Juan Manuel Leal <jleal@segmail.co>
 */

class ESHIP_Admin_Notices
{
    protected $messsage;

    public function __construct($messsage)
    {
        $this->messsage = $messsage;
    }

    public function success_message()
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Done!', $this->messsage); ?></p>
        </div>
        <?php
    }


    public function error_message() {
        ?>
        <div class="notice notice-error">
            <p><?php _e( $this->messsage ); ?></p>
        </div>
        <?php
    }

    public function run($data) {
        add_action( 'admin_notices', [$this, $data['callback']] );
    }
}