<?php get_header() ?>
<div id="content">
<?php the_post() ?>
    <div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">
        <h2 class="entry-title"><?php the_title() ?></h2>
<?php if (false) {?>
    <p class="byline"><span class="author vcard"><?php printf( __( 'By %s', 'quentin' ), '<a class="url fn n" href="' . get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span></p>
<?php 	 	 	
} else {
}
?>

    <div class="entry-content">
        <?php the_content() ?>
        <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'quentin' ) . '&after=</div>') ?>
    </div>

</div><!-- .post -->

<?php print_full_post_meta(); ?>

<?php comments_template() ?>
</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>
