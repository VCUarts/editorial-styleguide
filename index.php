<?php get_header(); ?>

			<div id="content">

				<div id="inner-content">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php
							if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title-head" itemprop="headline"><?php the_title(); ?></h1>

								</header> <?php // end article header ?>

								<section class="entry-content" itemprop="articleBody">
									<?php
										the_content();
									?>
								</section> <?php // end article section ?>

								<footer class="article-footer">

								</footer>

							</article>

							<?php endwhile; else : ?>
								<?php echo "sorry aint got nothing"; ?>
							<?php endif; 

							?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
