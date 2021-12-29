<?php
namespace Eship\Admin;

class Eship_Admin {

	public function enqueue_styles($plugin, $file, $ver)
    {
		wp_enqueue_style( $plugin, plugin_dir_url( dirname(__FILE__) ) . $file, array(), $ver );

	}

	public function enqueue_scripts($plugin, $file, $ver, $in_footer = FALSE)
    {
		wp_enqueue_script( $plugin, plugin_dir_url( dirname(__FILE__) ) . $file, array(), $ver, $in_footer );

	}

    public function check_capabilities()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
    }

    public function getHeaderImg()
    {
        return  __URL_SITE__ . 'public/images/eshipw.png';
    }

    public function getIconMenu()
    {
        return __URL_SITE__ . 'public/images/planeloader.png';
    }

    public function getImgWoocommerce()
    {
        return __URL_SITE__ . 'public/images/woocommerce.png';
    }
}