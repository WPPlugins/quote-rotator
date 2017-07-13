<?php
/*
Plugin Name: Quote Rotator
Plugin URI: http://www.lukehowell.com/quote-rotator/
Description: Creates widget to rotate user entered Quotes.
Version: 4.0.4
Author: Luke Howell
Author URI: http://www.lukehowell.com/

---------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
---------------------------------------------------------------------
*/

/* Quote Rotator versions */
if( !defined( QUOTE_ROTATOR_VERSION ) )
	define( 'QUOTE_ROTATOR_VERSION', '4.0.4' );
if( !defined( QUOTE_ROTATOR_DATABASE_VERSION ) )
	define( 'QUOTE_ROTATOR_DATABASE_VERSION', '0.6' );

if( !defined( QUOTE_ROTATOR_DATABASE_TABLE ) )
	define( 'QUOTE_ROTATOR_DATABASE_TABLE', 'thequoterotator' );

/* Language definition */
if( !defined( QUOTE_ROTATOR_I18N ) )
	define( 'EVENTS_CALENDAR_I18N', 'quote_rotator' );
	
/* Directory separator for paths */
if ( !defined( 'DS' ) )
	define( 'DS', DIRECTORY_SEPARATOR );

/* Quote Rotator paths */
if( !defined( QUOTE_ROTATOR_PATH ) )
	define( 'QUOTE_ROTATOR_PATH', dirname( __FILE__ ) . DS );
if( !defined( QUOTE_ROTATOR_CLASS_PATH ) )
	define( 'QUOTE_ROTATOR_CLASS_PATH', QUOTE_ROTATOR_PATH . 'classes' . DS );

/* Determine whether mu-plugins or standard plugins folder is being used define the main plugin url */
if( !defined( 'QUOTE_ROTATOR_URL' ) )
{
	if( strpos( QUOTE_ROTATOR_PATH, 'wp-content' . DS . 'mu-plugins' ) === false )
		define( 'QUOTE_ROTATOR_URL', plugins_url() . '/' . str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) ) );
	else
		define( 'QUOTE_ROTATOR_URL', content_url() . '/mu-plugins/' . str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) ) );
}
/* Define the urls for the plugin */
if( !defined( QUOTE_ROTATOR_IMAGE_URL ) )
	define( 'QUOTE_ROTATOR_IMAGE_URL', QUOTE_ROTATOR_URL . 'images/' );
if( !defined( QUOTE_ROTATOR_JS_URL ) )
	define( 'QUOTE_ROTATOR_JS_URL', QUOTE_ROTATOR_URL . 'js/' );

/* Message to display when someone is somewhere they shouldn't be */
if( !defined( NAUGHTY_MESSAGE ) )
	define( 'NAUGHTY_MESSAGE' , __( 'You are being naughty aren\'t you?  You shouldn\'t be here.' ) );

require_once( QUOTE_ROTATOR_CLASS_PATH . 'class-quote-rotator-plugin.php' );
require_once( QUOTE_ROTATOR_CLASS_PATH . 'class-quote-rotator-db.php' );
require_once( QUOTE_ROTATOR_CLASS_PATH . 'class-quote-rotator-widget.php' );
require_once( QUOTE_ROTATOR_CLASS_PATH . 'class-quote-rotator-admin.php' );
require_once( QUOTE_ROTATOR_CLASS_PATH . 'class-quote-rotator-shortcodes.php' );

$quote_rotator = new Quote_Rotator();

/* Register activation hook */
register_activation_hook( __FILE__, array( &$quote_rotator, 'activation' ) );

/* Add action for plugins_loaded */
add_action( 'plugins_loaded', array( &$quote_rotator, 'loaded' ) );

/* Add action for widget_init */
add_action( 'widgets_init', array( &$quote_rotator, 'widget_init' ) );

/* Add action to call the admin main page */
add_action( 'admin_menu', array( &$quote_rotator, 'admin_menu' ) );

/* Add action to the wp_print_styles hook */
add_action( 'wp_print_styles', array( &$quote_rotator, 'print_styles' ) );

/* Add action for wordpress init */
add_action( 'init', array( &$quote_rotator, 'init' ) );
?>
