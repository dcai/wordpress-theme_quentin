<?php get_header() ?>

		<div id="content">

			<h2 class="page-title"><?php _e( 'Category Archives:', 'quentin' ) ?> <span><?php single_cat_title() ?></span></h2>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>



<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php quentin_post_class() ?>">
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'quentin' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h2>
				
				<div class="entry-content">
<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'quentin' )) ?>

				</div>
				<div class="entry-meta">
					<span class="author vcard"><?php printf( __( 'By %s', 'quentin' ), '<a class="url fn n" href="' . get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) ?></span>
					Posted on <abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'quentin' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr> | 
<?php if ( $cats_meow = quentin_cats_meow(', ') ) : // Returns categories other than the one queried ?>
					<span class="cat-links"><?php printf( __( 'Also posted in %s', 'quentin' ), $cats_meow ) ?></span>
					<span class="meta-sep">|</span>
<?php endif ?>
					<?php the_tags( __( '<br /><span class="tag-links">Tagged ', 'quentin' ), ", ", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
<?php edit_post_link( __( 'Edit', 'quentin' ), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'quentin' ), __( 'Comments (1)', 'quentin' ), __( 'Comments (%)', 'quentin' ) ) ?></span>
				</div>
			</div><!-- .post -->

<?php endwhile; ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'quentin' ) ) ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'quentin' ) ) ?></div>
			</div>

		</div><!-- #content -->

<?php get_sidebar() ?>
<?php get_footer() ?>