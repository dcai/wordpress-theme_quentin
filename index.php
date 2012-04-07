<?php get_header() ?>
<div id="content">

<?php while ( have_posts() ) : the_post() ?>

<div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">

<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'quentin'), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h2>



<?php if (false) {    ?>
<p class="byline"><span class="author vcard"><?php printf( __( 'By %s', 'quentin' ), '<a class="url fn n" href="' . get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span></p>
<?php } else { }   ?>

<div class="entry-content">

<?php if (empty($qunt_excerpt)) {?>

<?php the_content( __( 'Read More <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?>
<?php } else { ?>
<?php the_excerpt( __( 'Read More <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?>
<?php }   ?>

<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'quentin' ) . '&after=</div>') ?>
</div>

<?php  // print_post_meta(); ?>

<!--<img src="<?php bloginfo('template_directory'); ?>/images/printer.gif" width="102" height="27" class="pmark" alt=" " />-->
<img src="<?php bloginfo('template_directory'); ?>/images/ornament-archaic.png" width="71" height="23" class="pmark" alt=" " />
</div><!-- .post -->

<?php comments_template() ?>

<?php endwhile; ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'quentin' )) ?></div>
				<div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'quentin' )) ?></div>
			</div>

</div><!-- #content -->


<?php get_sidebar() ?>
<?php get_footer() ?>
