<?php
namespace Eship\Admin;

class Eship_Admin {

	private $plugin;

	private $ver;

	public function __construct( $name, $version ) 
    {

		$this->plugin = $name;
		$this->ver = $version;

	}

	public function enqueue_styles()
    {
        var_dump(plugin_dir_url( __FILE__ ));
		//wp_enqueue_style( $this->plugin,  . 'css/plugin-name-admin.css', array(), $this->ver, 'all' );

	}

	public function enqueue_scripts() 
    {
		wp_enqueue_script( $this->plugin, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->ver, false );

	}

}