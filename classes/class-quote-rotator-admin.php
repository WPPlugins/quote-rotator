<?php
/*
 * File name: class-quote-rotator-admin.php
 */
if( !class_exists( 'Quote_Rotator_Admin' ) ) :
/*
 * Class name: Quote_Rotator_Admin
 * Purpose: Class to handle all the admin pages and functionality
 */
class Quote_Rotator_Admin
{	
	/*
	 * Function name: options_page
	 * Purpose: Print the output from get_main_page
	 * Arguments: $month - Month for the calendar.  If excluded it is null.
	 *						$year - Year for the calendar.  If excluded it is null.
	 */
	function options_page()
	{
		$options = get_option( 'quote_rotator_options', array() );
		$updated = false;
		
		if( isset( $_POST[ 'submit' ] ) )
		{
			if( !wp_verify_nonce( $_POST[ 'quote_rotator_options_nonce' ], 'quote_rotator_options' ) )
				die( NAUGHTY_MESSAGE );
			
			$options[ 'css' ] = $_POST['css'];
			
			update_option( 'quote_rotator_options', $options );
			
			$updated = true;
		}
		?>
		<div class="wrap">
		<div id="icon-edit-comments" class="icon32"></div>
		<h2><?php _e( 'Quote Rotator Options', 'quote_rotator' );?></h2>
		<?php if( $updated ):?>
			<div id="message" class="updated">
				<p>
					<strong>Your options have been saved.</strong>
				</p>
			</div>
			<?php endif;?>
		<form name="quote_rotator_options_form" method="post" action="<?php echo $_SERVER[ 'REQUEST_URI' ];?>">
			<?php wp_nonce_field( 'quote_rotator_options', 'quote_rotator_options_nonce' );?>
			<table class="form-table">
				<tbody>
					<tr valign="top" id="css_row">
						<th scope="row">
							<label for="css">CSS</label>
						</th>
						<td>
							<textarea id="css" name="css" cols="100" rows="20"><?php echo $options[ 'css' ];?></textarea>
						</td>
					</tr>
				</tbody>
			</table>	
			<input name="submit" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</form>
		</div>
		<?php
	}
	/*
	 * Function name: get_main_page
	 * Purpose: Return the content for the main admin page
	 */
	function get_main_page()
	{
		global $wpdb;
		
		$id = null;
		$message = '<div id="message" class="updated" style="visibility:hidden;">&nbsp;</div>';
		
		if( isset( $_POST[ 'quote_add_submit' ] ) || isset( $_POST[ 'quote_edit_submit' ] ))
		{
			if( !wp_verify_nonce( $_POST[ 'quote_rotator_nonce' ], 'quote_rotator' ) )
				die( NAUGHTY_MESSAGE );
			$quote_data = array(
				'quote' => $_POST[ 'quote_content' ],
				'author' => $_POST[ 'quote_author' ]
			);
			
			if( isset( $_POST[ 'quote_add_submit' ] ) )
			{
				$wpdb->insert( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data );
				$message = '<div id="message" class="updated">Your quote has been added.</div>';
			}
			elseif( isset( $_POST[ 'quote_edit_submit' ] ) )
			{
				$id = $_POST[ 'quote_id' ];
				if( is_null( $id ) || empty( $id ) || !is_numeric( $id ) )
					die( NAUGHTY_MESSAGE );
				$wpdb->update( $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE, $quote_data, array( 'id' => $id ) );
				$message = '<div id="message" class="updated">Quote #' . $id . ' has been updated.</div>';
			}
		}
		
		$id = null;
		
		if( isset( $_GET[ 'action' ] ) && isset( $_GET[ 'id' ] ) )
		{
			$id = $_GET[ 'id' ];
			if( is_null( $id ) || empty( $id ) || !is_numeric( $id ) )
				die( NAUGHTY_MESSAGE . 'aaa' );
			
			if( $_GET[ 'action' ] == 'delete' )
			{
				$wpdb->query( "DELETE FROM " . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . " WHERE id = '" . $id . "'");
				$message = '<div id="message" class="error">Quote #' . $id . ' has been deleted.</div>';
				$id = null;
			}
			elseif( $_GET[ 'action' ] == 'edit' )
			{
				
			}
			else
			{
				$id = null;
			}
		}
		
		$output = '';
		$output .= '<div class="wrap">';
		$output .= '<div id="icon-edit-comments" class="icon32"></div>';
		$output .= '<h2>' . __( 'Quote Rotator', 'quote_rotator' ) . '</h2>';
		$output .= $message;
		$output .= '<div id="quote_rotator_admin_wrapper" style="margin-top: -20px;">';
		$output .= is_null( $id ) ? '<h2>' . __( 'Add Quote', 'quote_rotator' ) . '</h2>' : '<h2>' . __( 'Edit Quote', 'quote_rotator' ) . '</h2>';
		$output .= $this->get_form( $id );
		$output .= '<h2>' . __( 'Quotes', 'quote_rotator' ) . '</h2>';
		$output .= $this->get_quotes();
		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
	
	/*
	 * Function name: main_page
	 * Purpose: Print the output from get_main_page
	 */
	function main_page()
	{
		echo $this->get_main_page();
	}
	
	/*
	 * Function name: get_quotes
	 * Purpose: Print the table with the quotes in it.
	 */
	function get_quotes()
	{
		global $wpdb;
		$output = '';
		$output .= '<table cellspacing="0" class="wp-list-table widefat fixed">';
		$output .= '<thead>';
		$output .= '<tr>';
		$output .= '<th id="author" style="width: 20%;" scope="col">Author</th>';
		$output .= '<th id="quote" style="width: 60%;" scope="col">Quote</th>';
		$output .= '<th scope="col"></th>';
		$output .= '<th scope="col"></th>';
		$output .= '</tr>';
		$output .= '</thead>';
		
		$output .= '<tfoot>';
		$output .= '<tr>';
		$output .= '<th id="author" style="width: 20%;" scope="col">Author</th>';
		$output .= '<th id="quote" style="width: 60%;" scope="col">Quote</th>';
		$output .= '<th scope="col"></th>';
		$output .= '<th scope="col"></th>';
		$output .= '</tr>';
		$output .= '</tfoot>';

		$output .= '<tbody id="the-list">';
		$quote_rows = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE );
		foreach( $quote_rows as $quote_row )
		{
			$output .= '<tr valign="top" class="alternate">';
			$output .= '<td>' . stripslashes( $quote_row->author ) . '</td>';
			$output .= '<td>' . stripslashes( $quote_row->quote ) . '</td>';
			$output .= '<td><a href="' . add_query_arg( array( 'id' => $quote_row->id, 'action' => 'edit' ) ) . '">Edit</a></td>';
			$output .= '<td><a href="' . add_query_arg( array( 'id' => $quote_row->id, 'action' => 'delete' ) ) . '">Delete</a></td>';
			$output .= '</tr>';

		}
		$output .= '</tbody>';
		$output .= '</table>';
		return $output;
	}
	
	/*
	 * Function name: get_form
	 * Purpose: Return the form to add and edit quotes.
	 */
	function get_form( $id = null )
	{	
		global $wpdb;
		
		$quote_content = '';
		$quote_author = '';
		
		$output = '';
		
		if( !is_null( $id ) )
		{
			if( !is_numeric( $id ) )
				die( NAUGHTY_MESSAGE );

			$quote_row = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . ' WHERE id = ' . $id );
			if( !is_null( $quote_row ) )
			{
				$quote_content = stripslashes( $quote_row->quote );
				$quote_author = htmlspecialchars( stripslashes( $quote_row->author ), ENT_QUOTES );
			}
		}
		
		$output .= '<form name="quote_rotator_form" method="post" action="' . remove_query_arg( array( 'id', 'action' ) ) . '">';
		$output .= wp_nonce_field( 'quote_rotator', 'quote_rotator_nonce', false );
		
		$output .= '<table class="form-table">';
		$output .= '<tbody>';
		
		$output .= '<tr valign="top" id="quote_content_row">';
		$output .= '<th scope="row" style="width: 50px;">';
		$output .= '<label for="quote_content">Quote</label>';
		$output .= '</th>';
		$output .= '<td>';
		$output .= '<textarea rows="5" cols="42" id="quote_content" name="quote_content" class="regular-text">' . $quote_content . '</textarea>';
		$output .= '</td>';
		$output .= '</tr>';
		
		$output .= '<tr valign="top" id="quote_author_row">';
		$output .= '<th scope="row" style="width: 50px;">';
		$output .= '<label for="quote_author">Author</label>';
		$output .= '</th>';
		$output .= '<td>';
		$output .= '<input id="quote_author" name="quote_author" class="regular-text" value="' . $quote_author . '">';
		$output .= '</td>';
		$output .= '</tr>';
		
		$output .= '</tbody>';
		$output .= '</table>';
		if( is_null( $id ) )
			$output .= '<input id="quote_add_submit" name="quote_add_submit" type="submit" class="button-primary" value="' . __('Add Quote') . '" />';
		else
		{
			$output .= '<input id="quote_edit_submit" name="quote_edit_submit" type="submit" class="button-primary" value="' . __('Update Quote') . '" />';
			$output .= '<input type="hidden" name="quote_id" value="' . $id . '" />';
			$output .= '<a href="' . menu_page_url( 'quote_rotator', false ) . '">Cancel</a>';
		}
		$output .= '</form>';
		
		return $output;
	}
}
endif;