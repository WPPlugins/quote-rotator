<?php
/*
 * File name: class-quote-rotator-widget-calendar.php
 */
if( !class_exists( 'Quote_Rotator_Widget_Calendar' ) ) :
/*
 * Class name: Quote_Rotator_Widget
 * Purpose: Class to define the widget for the calendar
 */
class Quote_Rotator_Widget extends WP_Widget
{
	function Quote_Rotator_Widget()
	{
		$this->WP_Widget( false, __( 'Quote Rotator', 'quote_rotator' ) );
		if ( is_active_widget( false, false, $this->id_base ) )
		{
      add_action( 'wp_head', array( &$this, 'wp_head' ) );
		}
	}
	
	function widget( $args, $instance )
	{
		global $wpdb;
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty( $instance[ 'title' ] ) ? 'Quote Rotator' : apply_filters( 'widget_title', $instance[ 'title' ] );
		$number = empty( $instance[ 'number' ] ) ? '5' : $instance[ 'number' ];
		$displaytime = empty( $instance[ 'displaytime' ] ) ? '5000' : $instance[ 'displaytime' ];
		$fadetime = empty( $instance[ 'fadetime' ] ) ? '700' : $instance[ 'fadetime' ];
		$random = empty( $instance[ 'random' ] ) ? 1 : $instance[ 'random' ];
		$height = empty( $instance[ 'height' ] ) ? 200 : $instance[ 'height' ];
		$output = '';
		if( !empty( $title ) )
		{
			$output .= $before_title . $title . $after_title;
		}
		$output .= '<div class="quote_rotator_widget_wrapper">';
		$output .= '<div id="rotated_quotes_' . $this->number . '" style="position:relative;">';
		if( $random )
			$sql = 'SELECT * from ' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . ' ORDER BY RAND() LIMIT 0,' . $number;
		else
			$sql = 'SELECT * from ' . $wpdb->prefix . QUOTE_ROTATOR_DATABASE_TABLE . ' LIMIT 0,' . $number;
		$quote_rows = $wpdb->get_results( $sql );
		foreach( $quote_rows as $quote_row )
		{
			$output .= '<div class="rotated_quote"><div class="quote">' . stripslashes( $quote_row->quote ) . '</div><div class="author">' . stripslashes( $quote_row->author ) . '</div></div>';
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= $after_widget;
		echo $output;
	}

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		if( is_numeric( $new_instance[ 'number' ] ) )
			$instance[ 'number' ] = $new_instance[ 'number' ];
		if( is_numeric( $new_instance[ 'displaytime' ] ) )
			$instance[ 'displaytime' ] = $new_instance[ 'displaytime' ];
		if( is_numeric( $new_instance[ 'fadetime' ] ) )
			$instance[ 'fadetime' ] = $new_instance[ 'fadetime' ];
		$instance[ 'random' ] = $new_instance[ 'random' ];
		if( is_numeric( $new_instance[ 'height' ] ) )
			$instance[ 'height' ] = $new_instance[ 'height' ];
		return $instance;
	}

	function form( $instance )
	{
		$title = 'Quote Rotator';
		$number = 5;
		$displaytime = 5000;
		$fadetime = 700;
		$random = 1;
		$height = 200;
		if( $instance )
		{
			$title = strip_tags( $instance[ 'title' ] );
			$number = $instance[ 'number' ];
			$displaytime = $instance[ 'displaytime' ];
			$fadetime = $instance[ 'fadetime' ];
			$random = $instance[ 'random' ];
			$height = $instance[ 'height' ];
		}
		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'quote_rotator' ) . '</label>: <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . attribute_escape( $title ) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'number' ) . '">' . __( 'Number of quotes', 'quote_rotator' ) . '</label>: <input class="narrowfat" id="' . $this->get_field_id( 'number' ) . '" name="' . $this->get_field_name( 'number' ) . '" type="text" value="' . attribute_escape( $number ) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'displaytime' ) . '">' . __( 'Show each how long (in milliseconds)', 'quote_rotator' ) . '</label>: <input class="narrowfat" id="' . $this->get_field_id( 'displaytime' ) . '" name="' . $this->get_field_name( 'displaytime' ) . '" type="text" value="' . attribute_escape( $displaytime ) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'fadetime' ) . '">' . __( 'Transistion time (in milliseconds)', 'quote_rotator' ) . '</label>: <input class="narrowfat" id="' . $this->get_field_id( 'fadetime' ) . '" name="' . $this->get_field_name( 'fadetime' ) . '" type="text" value="' . attribute_escape( $fadetime ) . '" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'random' ) . '">' . __( 'Random', 'quote_rotator' ) . '</label>? <input class="checkbox" type="checkbox" ' . checked( $random, 1, false ) . ' id="' . $this->get_field_id( 'random' ) . '" name="' .  $this->get_field_name( 'random' ) . '" value="1" /></p>';
		echo '<p><label for="' . $this->get_field_id( 'height' ) . '">' . __( 'Widget height (in pixels)', 'quote_rotator' ) . '</label>: <input class="narrowfat" id="' . $this->get_field_id( 'height' ) . '" name="' . $this->get_field_name( 'height' ) . '" type="text" value="' . attribute_escape( $height ) . '" /></p>';
	}
	
	function wp_head()
	{
		$options = $this->get_settings();
		$options = $options[ $this->number ];
		?>
		<script type="text/javascript">
		jQuery.noConflict();
		(function($)
		{
			$(window).load(function()
			{
				$('#rotated_quotes_<?php echo $this->number;?>' ).sideswap({
					navigation : false,
					transition_speed : <?php echo $options[ 'fadetime' ];?>,
					display_time : <?php echo $options[ 'displaytime' ];?>
				});
			});
		})(jQuery);
		</script>
		<style type="text/css">
			#rotated_quotes_<?php echo $this->number;?>
			{	
				min-height: <?php echo $options[ 'height' ];?>px;
			}
			.rotated_quote
			{
				min-height: <?php echo $options[ 'height' ];?>px;
				position: absolute;
				top: 0;
				left: 0;
			}
			<?php 
			$options = get_option( 'quote_rotator_options' );
			$css = $options[ 'css' ];
			echo $css;
			?>
		</style>
		<?php
	}
}
endif;