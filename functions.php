<?php
require_once 'functions/base.php';
require_once 'functions/config.php';
require_once 'functions/admin.php';
require_once 'custom-post-types.php';
require_once 'shortcodes.php';
//require_once 'widgets.php';

function body_classes() {
	$classes = array();

	if ( is_admin_bar_showing() ) {
		$classes[] = 'admin';
	}

	return implode( ' ', $classes );
}

// Theme options functions
function get_theme_mod_or_default( $mod, $fallback='' ) {
	return get_theme_mod( $mod, get_setting_default( $mod, $fallback ) );
}

// Header functions
function header_image_html() {
	$src = get_theme_mod_or_default( 'header_image' );

	ob_start();
?>
	<?php if ( $src ) : ?>
		<img class="header-image" width="100%" src="<?php echo $src; ?>">
	<?php endif; ?>
<?php
	return ob_get_clean();
}

// Footer functions
function get_footer_address() {
	$address = get_theme_mod_or_default( 'footer_address' );
	ob_start();
	if ( $address ) { ?>
		<div class="col-md-3">
			<h3>Address</h3>
			<address>
			<?php echo $address; ?>
			</address>
		</div>
		<?php
	}
	return ob_get_clean();
}

function get_footer_contact() {
	$phone = get_theme_mod_or_default( 'footer_phone' );
	$page = get_theme_mod_or_default( 'footer_contact_page' );

	ob_start(); ?>

	<?php if ( $phone || $page ) : ?>
		<div class="col-md-3">
			<h3>Contact Information</h3>
			<?php if ( $phone ) : ?>
			<p><a href="tel:<?php echo str_replace( $phone, '-', ''); ?>"><?php echo $phone; ?></a></p>
			<?php endif; ?>
			<?php if ( $page ) : $page_url = get_permalink( $page ); ?>
			<p><a class="btn btn-lg btn-primary" href="<?php echo $page_url; ?>">Contact Us</a></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}

function get_social_icons( $classes=null ) {
	$googleplus_url = get_theme_mod_or_default( 'googleplus_url' );
	$twitter_url = get_theme_mod_or_default( 'twitter_url' );
	$facebook_url = get_theme_mod_or_default( 'facebook_url' );
	$instagram_url = get_theme_mod_or_default( 'instagram_url' );
	$youtube_url = get_theme_mod_or_default( 'youtube_url' );

	$googleplus_class = 'btn-googleplus';
	$twitter_class = 'btn-twitter';
	$facebook_class = 'btn-facebook';
	$instagram_class = 'btn-instagram';
	$youtube_class = 'btn-youtube';

	ob_start();
?>
<?php if ( $googleplus_url || $twitter_url || $facebook_url || $instagram_url || $youtube_url ) : ?>
<div class="col-md-3">
	<h3>Connect with Us</h3>
	<div class="social <?php if ( $classes ) : echo $classes; endif; ?>">
		<?php if ( $googleplus_url ) : ?>
		<a class="<?php echo $googleplus_class; ?> ga-event-link" target="_blank" href="<?php echo $googleplus_url; ?>">Follow us on Google+</a>
		<?php endif; ?>
		<?php if ( $twitter_url ) : ?>
		<a class="<?php echo $twitter_class; ?> ga-event-link" target="_blank" href="<?php echo $twitter_url; ?>">Follow us on Twitter</a>
		<?php endif; ?>
		<?php if ( $facebook_url ) : ?>
		<a class="<?php echo $facebook_class; ?> ga-event-link" target="_blank" href="<?php echo $facebook_url; ?>">Follow us on Facebook</a>
		<?php endif; ?>
		<?php if ( $instagram_url ) : ?>
		<a class="<?php echo $instagram_class; ?> ga-event-link" target="_blank" href="<?php echo $instagram_url; ?>">Follow us on Instagram</a>
		<?php endif; ?>
		<?php if ( $youtube_url ) : ?>
		<a class="<?php echo $youtube_class; ?> ga-event-link" target="_blank" href="<?php echo $youtube_url; ?>">Follow us on YouTube</a>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<?php
	return ob_get_clean();
}

function get_footer_service_times() {
	
}

?>