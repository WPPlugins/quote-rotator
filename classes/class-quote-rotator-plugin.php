<?php/* * File name: class-quote-rotator-admin.php */if( !class_exists( 'Quote_Rotator' ) ):/* * Class name: Quote_Rotator * Purpose: Serves as main plugin class */class Quote_Rotator{			function activation()	{		$db = new Quote_Rotator_DB();		$db->install();		$options = array( 'css' => '' );		add_option( 'quote_rotator_options', $options );	}	function loaded()	{		$db = new Quote_Rotator_DB();		$db->upgrade();	}		function widget_init()	{		register_widget( 'Quote_Rotator_Widget' );	}		function admin_init()	{	}		function admin_styles()	{	}		function admin_menu()	{		add_action( 'admin_init', array( &$this, 'admin_init' ) );		$main_page = add_posts_page( __( 'Quote Rotator', 'quote_rotator' ), __( 'Quotes', 'quote_rotator' ), 'moderate_comments', 'quote_rotator', array( &$this, 'admin_main_page' ) );		$options_page = add_options_page( __( 'Quote Rotator Options', 'quote_rotator' ), __( 'Quote Rotator', 'quote_rotator' ), 'manage_options', 'quote_rotator_options', array( &$this, 'admin_options_page' ));	}		function admin_main_page()	{		$id = isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ? $_GET[ 'id' ] : null;		$action = isset( $_GET[ 'action' ] ) && !empty( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : null;		$admin = new Quote_Rotator_Admin();		$admin->main_page();	}		function admin_options_page()	{		$admin = new Quote_Rotator_Admin();		$admin->options_page();	}		function print_styles()	{		wp_register_style( 'quote_rotator_frontend_style', QUOTE_ROTATOR_CSS_URL . 'frontend-style.css' );		wp_enqueue_style( 'quote_rotator_frontend_style' );	}		function init()	{		wp_enqueue_script( 'jq_side_swap', QUOTE_ROTATOR_JS_URL . 'jquery.sideswap.js', array( 'jquery' ) );		$shortcodes = new Quote_Rotator_ShortCodes();		add_shortcode( 'quote_rotator', array( &$shortcodes, 'quote_rotator' ) );	}}endif;?>