<?php get_header() ?>

		<div id="content">

			<h2 class="page-title"><?php _e( 'Tag Archives:', 'quentin' ) ?> <span><?php single_tag_title() ?></span></h2>


<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'quentin' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				<div class="entry-content">
<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'quentin' )) ?>

				</div>
<?php print_post_meta(); ?>
			</div><!-- .post -->

<?php endwhile; ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'quentin' ) ) ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?></div>
			</div>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>
