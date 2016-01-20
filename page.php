<?php
/**
 * Default page template
 **/
get_header();
while ( have_posts() ) : the_post(); 
?>
	<div class="title-card-wrapper">
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
	<article>
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</article>
</main>
<?php endwhile; 
get_footer();
?>