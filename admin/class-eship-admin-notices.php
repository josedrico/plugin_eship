<?php
namespace EshipAdmin;
/**
 * Class for native wordpress notifications
 *
 * @since      1.0.0
 * @package    ESHIP
 * @author     juanmaleal
 *
 * @property string $message
 */

class ESHIP_Admin_Notices
{
    protected $messsage;

    public function __construct($message)
    {
        $this->messsage = $message;
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
}