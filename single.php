<?php get_header() ?>
<div id="post-content">
<?php the_post() ?>
    <div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">
    <h2 class="entry-title"><?php the_title() ?></h2>
    <div class="entry-content">
        <?php the_content() ?>
        <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'quentin' ) . '&after=</div>') ?>
    </div>
</div><!-- .post -->

<?php print_full_post_meta(); ?>

<?php comments_template() ?>
</div><!-- #content -->

<?php get_footer() ?>
