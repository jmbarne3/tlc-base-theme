<?php get_header(); ?>

<main>
	<?php while ( have_posts() ): the_post(); ?>
	<article class="<?php echo $post->post_status; ?>">
		<div class="container">
			<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<div class="meta">
				<span class="date"><?php the_time( 'F j, Y' ); ?></span>
				<span class="author">by <?php the_author_posts_link(); ?></span>
			</div>
			<div class="summary">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>