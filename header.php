<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title( '' ); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
    <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
  
			<div class="vcubar">
			    <div class="inner-vcubar">
			      <a href="http://vcu.edu" target="_blank" class="vcu"><?php include( TEMPLATEPATH . '/library/images/svg/logo-vcu.svg' ); ?></a>
			      <a href="http://arts.vcu.edu" target="_blank" class="vcuarts"><?php include( TEMPLATEPATH . '/library/images/svg/logo-vcuarts.svg' ); ?></a>
			    </div>
 			 </div>

			<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="inner-header">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<div id="logo" itemscope itemtype="http://schema.org/Organization">
						<a class="h2" href="<?php echo esc_url( home_url() ); ?>" rel="nofollow">
							<?php bloginfo( 'name' ); ?>
						</a>
					</div>

					<nav role="navigation" class="header-nav" itemscope itemtype="http://schema.org/SiteNavigationElement">
								<?php
		              $args = array(
		                'child_of'     => 0,
		                'depth'        => 0,
		                'echo'         => 1,
		                'exclude'      => '',
		                'include'      => '',
		                'link_after'   => '',
		                'link_before'  => '',
		                'post_type'    => 'page',
		                'post_status'  => 'publish',
		                'sort_column'  => 'post_title',
                    'sort_order'   => 'ASC',
		                'title_li'     => __( '' ),
		                'walker' => new Skips_Walker(),
		              );
		              wp_list_pages( $args );
		            ?>
					
		            <!-- Sidebar start -->
					<?php get_sidebar(); ?>


		          </nav>
				</div>

				<div class="show-nav">
		          	<i class="fa fa-bars"></i>
		          </div>

			</header>
