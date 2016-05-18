<?php get_header(); ?>

			<div id="content">

				<div id="inner-content">

					<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<?php
							if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<?php if (0 == $post->post_parent): ?>
										<h1 class="page-title-head <?php echo sanitize_title( the_title() ); ?>" itemprop="headline"><?php the_title(); ?></h1>
									<?php else: ?>
										<h2 class="page-title-head" itemprop="headline"><?php the_title(); ?></h2>
									<?php endif; ?>

								</header> <?php // end article header ?>

								<section class="entry-content" itemprop="articleBody">
									<?php
										the_content();
									?>
								</section> <?php // end article section ?>


								<footer class="article-footer">

								</footer>

							</article>

              <?php
                $child_args = array(
                    'sort_order' => 'ASC',
                    //'sort_column' => 'menu_order',
                    'child_of' => get_the_ID(),
                );
                $child_list = get_pages( $child_args );
                foreach ( $child_list as $child ) { ?>

                    <article id="post-<?php echo esc_attr( $child->ID ); ?>" <?php echo esc_attr( $child->post_class ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                        <h2 class="child-title"><?php echo $child->post_title; ?><?php edit_post_link( 'Edit', '<span class="edit-link">', '</span>', $child->ID ); ?></h2>
                        <section class="entry-content" itemprop="articleBody">
                          <?php echo apply_filters( 'the_content', $child->post_content); ?>
                        </section>
                    </article>

                <?php } ?>

							<?php endwhile; else : ?>
								<?php echo "sorry aint got nothing"; ?>
							<?php endif; 

							?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
