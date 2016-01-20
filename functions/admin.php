<?php
/**
 * Customization of Admin Menus go here
 **/
function add_shortcode_interface() {
	ob_start();
?>
	<a href="#TB_inline?width=600&height=700&inlineId=select-shortcode-form" class="thickbox button" id="add-shortcode" title="Add Shortcode">Add Shortcode</a>
<?php
	echo ob_get_clean();
}

add_action( 'media_buttons', 'add_shortcode_interface', 11);

function add_shortcode_interface_modal() {
	$page = basename( $_SERVER['PHP_SELF'] );
	if ( in_array( $page, array( 'post.php', 'page.php', 'page-new.php', 'post-new.php' ) ) ) {
		include_once( THEME_DIR . '/includes/shortcode-interface.php' );
	}
}
add_action( 'admin_footer', 'add_shortcode_interface_modal');

?>
