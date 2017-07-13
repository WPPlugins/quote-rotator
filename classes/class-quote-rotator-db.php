<?php
/*
 * File name: class-quote-rotator-db.php
 */
if( !class_exists( 'Quote_Rotator_DB' ) ) :
/*
 * Class name: Quote_Rotator_DB
 * Purpose: Class to handle all the database interactions for the plugin
 */
class Quote_Rotator_DB
{
	/*
	 * Function name: install
	 * Purpose: Install the database tables
	 */
	function install()
	{
		global $wpdb;
		
		$sql1 = '
		CREATE TABLE `' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . '` (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`quote` text,
			`author` varchar(255),
			PRIMARY KEY (`id`)
		);
		';
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		dbDelta($sql1);
		
		$sql = 'SELECT * FROM ' . $wpdb->prefix . 'QuoteRotator';
		$results = $wpdb->get_results( $sql );
		foreach( $results as $result )
		{
			$quote_data = array(
				'quote' => $result->quote,
				'author' => $result->author
			);
			$wpdb->insert( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data );
		}
		
		$sql = 'SELECT * FROM ' . $wpdb->prefix . 'quoterotator';
		$results = $wpdb->get_results( $sql );
		foreach( $results as $result )
		{
			$quote_data = array(
				'quote' => $result->quote,
				'author' => $result->author
			);
			$wpdb->insert( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data );
		}
		
		add_option( 'quote_rotator_database_version', QUOTE_ROTATOR_DATABASE_VERSION );
	}
	
	/*
	 * Function name: upgrade
	 * Purpose: Upgrade database when needed
	 */
	function upgrade()
	{
		global $wpdb;
		
		$installed_version = get_option( 'quote_rotator_database_version' );

		if( $installed_version != QUOTE_ROTATOR_DATABASE_VERSION ) :
		
		$sql1 = '
		CREATE TABLE `' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . '` (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`quote` text,
			`author` varchar(255),
			PRIMARY KEY (`id`)
		);
		';
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		dbDelta($sql1);
		
		$sql = 'SELECT * FROM ' . $wpdb->prefix . 'QuoteRotator';
		$results = $wpdb->get_results( $sql );
		foreach( $results as $result )
		{
			$quote_data = array(
				'quote' => $result->quote,
				'author' => $result->author
			);
			$wpdb->insert( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data );
		}
		
		if( $installed_version == '0.6' )
		{
			$sql = 'SELECT * FROM ' . $wpdb->prefix . 'quoterotator';
			$results = $wpdb->get_results( $sql );
			foreach( $results as $result )
			{
				$quote_data = array(
					'quote' => $result->quote,
					'author' => $result->author
				);
				$wpdb->insert( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data );
			}
		}
		
		update_option( 'quote_rotator_database_version', QUOTE_ROTATOR_DATABASE_VERSION );
		
		endif;
	}
}
endif;