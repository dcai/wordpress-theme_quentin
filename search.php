<?php get_header() ?>

		<div id="content">

<?php if ( have_posts() ) : ?>

		<h2 class="page-title"><?php _e( 'Search Results for:', 'quentin' ) ?> <span><?php the_search_query() ?></span></h2>


<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'quentin' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				
				<div class="entry-content">
<?php the_excerpt( __( 'Read More <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?>

				</div>

<?php if ( $post->post_type == 'post' ) { ?>
				<div class="entry-meta">
					<span class="author vcard"><?php printf( __( 'By %s', 'quentin' ), '<a class="url fn n" href="' . get_author_link( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span>
					<span class="meta-sep">|</span>
					<span class="cat-links"><?php printf( __( 'Posted in %s', 'quentin' ), get_the_category_list(', ') ) ?></span>
					on <div class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'quentin' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></div> <br />
					<?php the_tags( __( '<span class="tag-links">Tagged ', 'quentin' ), ", ", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
<?php edit_post_link( __( 'Edit', 'quentin' ), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'quentin' ), __( 'Comments (1)', 'quentin' ), __( 'Comments (%)', 'quentin' ) ) ?></span>
				</div>
<?php } ?>

			</div><!-- .post -->

<?php endwhile; ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older results', 'quentin' ) ) ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer results <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?></div>
			</div>

<?php else : ?>

			<div id="post-0" class="post no-results not-found">
				<h2 class="entry-title"><?php _e( 'Nothing Found', 'quentin' ) ?></h2>
				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'quentin' ) ?></p>
				</div>
				<form id="searchform-no-results" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s-no-results" name="s" class="text" type="text" value="<?php the_search_query() ?>" size="40" />
						<input class="button" type="submit" value="<?php _e( 'Find', 'quentin' ) ?>" />
					</div>
				</form>
			</div><!-- .post -->

<?php endif; ?>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>