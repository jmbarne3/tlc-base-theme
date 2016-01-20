<?php
/**
 * Widgets
 **/

/**
 * Icon Button Widget
 * @author Jim Barnes
 **/
class IconButton_Widget extends WP_Widget {
	/**
	 * Sets up the widget
	 **/
	public function __construct() {
		parent::__construct(
			'iconbutton_widget',
			__( 'Icon Button' ),
			array( 'description' => __( 'Displays an icon button.' ) )
		);
	}

	/**
	 * Outputs the content of the widget
	 * @param array $args
	 * @param array $instance
	 **/
	public function widget( $args, $instance ) {
		echo do_shortcode( 
			"[icon-button btn_color='" . $instance['btn_color'] . "' btn_text='" . $instance['btn_text']
			. "' color='" . $instance['color'] . "' text='" . $instance['text'] . "' url='" . $instance['url']
			. "' icon='" . $instance['url'] . "']"
		);
	}

	/**
	 * Outputs the options form on admin screen
	 * @param array @instance
	 **/
	public function form( $instance ) {
		$btn_color = ! empty( $instance['btn_color'] ) ? $instance['btn_color'] : 'btn-info';
		$btn_text = ! empty( $instance['btn_text'] ) ? $instance['btn_text'] : '';
		$color = ! empty( $instance['color'] ) ? $instance['color'] : '#428bca';
		$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
		$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php echo __('Title'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text );?>">
		</p>
<?php
	}

	/**
	 * Processes the widget options on save
	 * @param array $new_instance
	 * @param array $old_instance
	 **/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		return $instance;
	}
}

function register_input_button_widget() {
	register_widget( 'IconButton_Widget' );
}
add_action( 'widgets_init', 'register_input_button_widget' );

?>