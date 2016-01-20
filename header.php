<?php
/*
Header file. Used to load navigation bar and <head> tags.
*/
?>
<!Doctype html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
	</head>
	<body ontouchstart class="<?php echo body_classes(); ?>">
		<header id="site-header">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-nav" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo get_home_url(); ?>">TLC</a>
					</div>
					<div class="collapse navbar-collapse" id="site-nav">
						<?php
							echo wp_nav_menu( array (
								'theme_location' => 'header-menu',
								'container' => False,
								'menu_class' => 'nav navbar-nav',
								'menu_id' => 'header-menu',
								'walker' => new Bootstrap_Walker_Nav_Menu()
							) );
						?>
					</div>
				</div>
			</nav>
		