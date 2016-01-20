<?php
/**
 * Front page template.
 */
get_header();
?>
	<div class="title-card-wrapper front-page">
		<div class="title-card">
			<div class="site-meta">
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_url( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<h2 class="site-description">
					<?php bloginfo( 'description' ); ?>
				</h2>
				<a href="#more-site-anchor" id="more-site" class="btn btn-default btn-lg"><?php _e( 'Our Vision' ); ?></a>
			</div>
			<?php echo header_image_html(); ?>
		</div>
	</div>
</header>
<main>
	<article class="front-page">
		<div class="container">
			<div class="jumbotron">
				<h2 id="more-site-anchor"><?php echo get_theme_mod_or_default( 'homepage_title', null ); ?></h2>
				<p><?php echo get_theme_mod_or_default( 'homepage_content', null ); ?></p>
			</div>
			<?php echo do_shortcode("[icon-button icon='fa-gittip' text='Planning Your Visit']"); ?>
		</div>
	</article>
</main>

<?php get_footer(); ?>
