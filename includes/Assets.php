<?php

namespace Thrail\Crm;

class Assets {

	public $plugin;
	public $slug;
	public $name;
	public $version;
	public $assets;

	function __construct() {
		// $this->plugin	= $plugin;
		// $this->slug		= $this->plugin['TextDomain'];
		// $this->name		= $this->plugin['Name'];
		// $this->version	= $this->plugin['Version'];
		// $this->assets 	= THRAIL_CRM_ASSETS;

		add_action('wp_enqueue_scripts', [$this, 'register_frontend_assets']);
		add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
	}

	public function get_scripts() {
		return [
			'thrail-script' => [
				'src'     => THRAIL_CRM_ASSETS . '/js/frontend.js',
				'version' => filemtime(THRAIL_CRM_PATH . '/assets/js/frontend.js'),
				'deps'    => ['jquery']
			],
			// 'thrail-enquiry-script' => [
			// 	'src'     => THRAIL_CRM_ASSETS . '/js/enquiry.js',
			// 	'version' => filemtime(THRAIL_CRM_PATH . '/assets/js/enquiry.js'),
			// 	'deps'    => ['jquery']
			// ],
			'thrail-admin-script' => [
				'src'     => THRAIL_CRM_ASSETS . '/js/admin.js',
				'version' => filemtime( THRAIL_CRM_PATH . '/assets/js/admin.js' ),
				'deps'    => [ 'jquery', 'wp-util', 'jquery-ui-dialog' ]
			],
		];
	}

	public function get_styles() {
		return [
			'thrail-style' => [
				'src'     => THRAIL_CRM_ASSETS . '/css/frontend.css',
				'version' => filemtime( THRAIL_CRM_PATH . '/assets/css/frontend.css' )
			],
			'thrail-admin-style' => [
				'src'     => THRAIL_CRM_ASSETS . '/css/admin.css',
				'version' => filemtime( THRAIL_CRM_PATH . '/assets/css/admin.css' ),
				'deps'    => [ 'wp-jquery-ui-dialog' ]
			],
			'jquery-ui' => [
				'src'     => THRAIL_CRM_ASSETS . '/css/jquery-ui.css',
				'version' => filemtime( THRAIL_CRM_PATH . '/assets/css/jquery-ui.css' )
			],
		];
	}

	public function register_frontend_assets() {
		$scripts 	= $this->get_scripts();
		$styles 	= $this->get_styles();

		wp_register_script( 'thrail-script', $scripts[ 'thrail-script' ][ 'src' ], $scripts[ 'thrail-script' ][ 'deps' ], $scripts[ 'thrail-script' ][ 'version' ], true );

		// wp_register_script('thrail-enquiry-script', $scripts['thrail-enquiry-script']['src'], $scripts['thrail-enquiry-script']['deps'], $scripts['thrail-enquiry-script']['version'], true);

		wp_localize_script( 'thrail-script', 'THRAIL', [
			'ajaxurl' => admin_url( 'admin-ajax.php'),
			'resturl' => rest_url( "thrail-crm/v1/submit" ),
			'nonce'   => wp_create_nonce( 'nonce'),
			'error'   => __( 'Something went wrong', 'thrail-crm' )
		]);

		wp_register_style( 'thrail-style', $styles[ 'thrail-style' ][ 'src' ], [], $styles[ 'thrail-style' ]['version' ] );

		wp_enqueue_script( 'thrail-script' );
		// wp_enqueue_script('thrail-enquiry-script');
		wp_enqueue_style( 'thrail-style' );
	}

	public function register_admin_assets($hook_suffix) {
		$scripts 	= $this->get_scripts();
		$styles 	= $this->get_styles();

		wp_register_script( 'thrail-admin-script', $scripts[ 'thrail-admin-script' ][ 'src' ], $scripts['thrail-admin-script' ][ 'deps' ], $scripts[ 'thrail-admin-script' ][ 'version' ], true );
		
		wp_localize_script( 'thrail-admin-script', 'THRAIL', [
			'nonce'   	=> wp_create_nonce( 'nonce' ),
			'confirm' 	=> __( 'Are you sure?', 'thrail-crm' ),
			'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
			'rest_base'	=> untrailingslashit( rest_url( '/thrail-crm/v1' ) ),
			'error'   	=> __( 'Something went wrong', 'thrail-crm' )
		]);

		wp_register_style( 'thrail-admin-style', $styles[ 'thrail-admin-style' ][ 'src' ], [], $styles['thrail-admin-style' ][ 'version' ]);
		wp_register_style( 'jquery-ui', $styles[ 'jquery-ui' ][ 'src' ], [], $styles[ 'jquery-ui' ][ 'version' ] );

		wp_enqueue_script( 'thrail-admin-script' );
		wp_enqueue_style( 'thrail-admin-style' );
		wp_enqueue_style( 'jquery-ui' );
	}
}