<?php
// This file is part of The Quentin Theme for WordPress
// http://pikemurdy.com/quentin
//
// Copyright (c) 2010 Mike Purdy. All rights reserved.
// http://pikemurdy.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************

function print_post_meta($date = true, $category = true, $tag = true, $comments = true, $editlink = true) {
    global $authordata;
    echo "<div class='entry-meta'>";
    echo "<span class='author vcard'>" . sprintf( __( 'By %s', 'quentin' ), '<a class="url fn n" href="' . get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a>' ) . "</span>";

    if ($date) {
        echo " • ";
        echo "<abbr class='published'>";
        echo sprintf(__( '%1$s &#8211; %2$s', 'quentin' ), the_date( '', '', '', false ), get_the_time());
        echo "</abbr>";
    }
    if ($tag) {
        echo " • ";
        echo '<span class="cat-links">';
        printf(__( 'Posted in %s', 'quentin' ), get_the_category_list(', '));
        echo "</span>";
    }
    if ($tag && get_the_tag_list()) {
        echo " • ";
        the_tags(  '<span class="tag-links">Tagged ', ", ", "</span>" );
    }
    if ($comments) {
        echo " • ";
        echo "<span class='comments-link'>";
        comments_popup_link( __( 'Comments (0)', 'quentin' ), __( 'Comments (1)', 'quentin' ), __( 'Comments (%)', 'quentin' ) );
        echo "</span>";
    }
    if ($editlink && get_edit_post_link()) {
        echo " • ";
        edit_post_link( __( 'Edit', 'quentin' ), "<span class=\"edit-link\">", "</span>" );
    }

    echo "</div>";
}

function print_full_post_meta() {
    global $authordata, $post;
    echo '<div class="entry-meta">';
    printf('Written by %1$s, posted on <abbr class="published" title="%2$sT%3$s">%4$s at %5$s</abbr>, filed under %6$s%7$s. Bookmark the <a href="%8$s" title="Permalink to %9$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%10$s" title="Comments RSS to %9$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.',
    '<span class="author vcard"><a class="url fn n" href="' . get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ) . '" title="' . sprintf( __( 'View all posts by %s', 'quentin' ), $authordata->display_name ) . '">' . get_the_author() . '</a></span>',
    get_the_time('Y-m-d'),
    get_the_time('H:i:sO'),
    the_date( '', '', '', false ),
    get_the_time(),
    get_the_category_list(', '),
    get_the_tag_list( __( ' and tagged ', 'quentin' ), ', ', '' ),
    get_permalink(),
    the_title_attribute('echo=0'),
    get_post_comments_feed_link()
    );

    if ( ('open' == $post->comment_status) && ('open' == $post->ping_status) ) { // Comments and trackbacks open
        printf('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.',
            get_trackback_url() );
    } elseif ( !('open' == $post->comment_status) && ('open' == $post->ping_status) ) { // Only trackbacks open
        printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'quentin' ), get_trackback_url() );
    } elseif ( ('open' == $post->comment_status) && !('open' == $post->ping_status) ) { // Only comments open
         _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'quentin' );
    } elseif ( !('open' == $post->comment_status) && !('open' == $post->ping_status) ) { // Comments and trackbacks closed
        _e( 'Both comments and trackbacks are currently closed.', 'quentin' );
    }
    edit_post_link( __( 'Edit', 'quentin' ), '<span class="edit-link">', "</span>" );

    echo "</div><!-- entry-meta -->";
}

// Generates semantic classes for BODY element
function quentin_body_class( $print = true ) {
    global $wp_query, $current_user;

    // It's surely a WordPress blog, right?
    $c = array('wordpress');

    // Applies the time- and date-based classes (below) to BODY element
    quentin_date_classes( time(), $c );

    // Generic semantic classes for what type of content is displayed
    is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
    is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
    is_archive()     ? $c[] = 'archive'    : null;
    is_date()        ? $c[] = 'date'       : null;
    is_search()      ? $c[] = 'search'     : null;
    is_paged()       ? $c[] = 'paged'      : null;
    is_attachment()  ? $c[] = 'attachment' : null;
    is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

    // Special classes for BODY element when a single post
    if ( is_single() ) {
        $postID = $wp_query->post->ID;
        the_post();

        // Adds 'single' class and class with the post ID
        $c[] = 'single postid-' . $postID;

        // Adds classes for the month, day, and hour when the post was published
        if ( isset( $wp_query->post->post_date ) )
            quentin_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

        // Adds category classes for each category on single posts
        if ( $cats = get_the_category() )
            foreach ( $cats as $cat )
                $c[] = 's-category-' . $cat->slug;

        // Adds tag classes for each tags on single posts
        if ( $tags = get_the_tags() )
            foreach ( $tags as $tag )
                $c[] = 's-tag-' . $tag->slug;

        // Adds MIME-specific classes for attachments
        if ( is_attachment() ) {
            $mime_type = get_post_mime_type();
            $mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
            $c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
        }

        // Adds author class for the post author
        $c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
        rewind_posts();
    }

    // Author name classes for BODY on author archives
    elseif ( is_author() ) {
        $author = $wp_query->get_queried_object();
        $c[] = 'author';
        $c[] = 'author-' . $author->user_nicename;
    }

    // Category name classes for BODY on category archvies
    elseif ( is_category() ) {
        $cat = $wp_query->get_queried_object();
        $c[] = 'category';
        $c[] = 'category-' . $cat->slug;
    }

    // Tag name classes for BODY on tag archives
    elseif ( is_tag() ) {
        $tags = $wp_query->get_queried_object();
        $c[] = 'tag';
        $c[] = 'tag-' . $tags->slug;
    }

    // Page author for BODY on 'pages'
    elseif ( is_page() ) {
        $pageID = $wp_query->post->ID;
        $page_children = wp_list_pages("child_of=$pageID&echo=0");
        the_post();
        $c[] = 'page pageid-' . $pageID;
        $c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author()));
        // Checks to see if the page has children and/or is a child page; props to Adam
        if ( $page_children )
            $c[] = 'page-parent';
        if ( $wp_query->post->post_parent )
            $c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
        if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
            $c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
        rewind_posts();
    }

    // Search classes for results or no results
    elseif ( is_search() ) {
        the_post();
        if ( have_posts() ) {
            $c[] = 'search-results';
        } else {
            $c[] = 'search-no-results';
        }
        rewind_posts();
    }

    // For when a visitor is logged in while browsing
    if ( $current_user->ID )
        $c[] = 'loggedin';

    // Paged classes; for 'page X' classes of index, single, etc.
    if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
        // Thanks to Prentiss Riddle, twitter.com/pzriddle, for the security fix below.
        $page = intval($page); // Ensures that an integer (not some dangerous script) is passed for the variable
        $c[] = 'paged-' . $page;
        if ( is_single() ) {
            $c[] = 'single-paged-' . $page;
        } elseif ( is_page() ) {
            $c[] = 'page-paged-' . $page;
        } elseif ( is_category() ) {
            $c[] = 'category-paged-' . $page;
        } elseif ( is_tag() ) {
            $c[] = 'tag-paged-' . $page;
        } elseif ( is_date() ) {
            $c[] = 'date-paged-' . $page;
        } elseif ( is_author() ) {
            $c[] = 'author-paged-' . $page;
        } elseif ( is_search() ) {
            $c[] = 'search-paged-' . $page;
        }
    }

    // Separates classes with a single space, collates classes for BODY
    $c = join( ' ', apply_filters( 'body_class',  $c ) ); // Available filter: body_class

    // And tada!
    return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function quentin_post_class( $print = true ) {
    global $post, $quentin_post_alt;

    // hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
    $c = array( 'hentry', "p$quentin_post_alt", $post->post_type, $post->post_status );

    // Author for the post queried
    $c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author()));

    // Category for the post queried
    foreach ( (array) get_the_category() as $cat )
        $c[] = 'category-' . $cat->slug;

    // Tags for the post queried; if not tagged, use .untagged
    if ( get_the_tags() == null ) {
        $c[] = 'untagged';
    } else {
        foreach ( (array) get_the_tags() as $tag )
            $c[] = 'tag-' . $tag->slug;
    }

    // For password-protected posts
    if ( $post->post_password )
        $c[] = 'protected';

    // Applies the time- and date-based classes (below) to post DIV
    quentin_date_classes( mysql2date( 'U', $post->post_date ), $c );

    // If it's the other to the every, then add 'alt' class
    if ( ++$quentin_post_alt % 2 )
        $c[] = 'alt';

    // Separates classes with a single space, collates classes for post DIV
    $c = join( ' ', apply_filters( 'post_class', $c ) ); // Available filter: post_class

    // And tada!
    return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$quentin_post_alt = 1;

// Generates semantic classes for each comment LI element
function quentin_comment_class( $print = true ) {
    global $comment, $post, $quentin_comment_alt;

    // Collects the comment type (comment, trackback),
    $c = array( $comment->comment_type );

    // Counts trackbacks (t[n]) or comments (c[n])
    if ( $comment->comment_type == 'comment' ) {
        $c[] = "c$quentin_comment_alt";
    } else {
        $c[] = "t$quentin_comment_alt";
    }

    // If the comment author has an id (registered), then print the log in name
    if ( $comment->user_id > 0 ) {
        $user = get_userdata($comment->user_id);
        // For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
        $c[] = 'byuser comment-author-' . sanitize_title_with_dashes(strtolower( $user->user_login ));
        // For comment authors who are the author of the post
        if ( $comment->user_id === $post->post_author )
            $c[] = 'bypostauthor';
    }

    // If it's the other to the every, then add 'alt' class; collects time- and date-based classes
    quentin_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
    if ( ++$quentin_comment_alt % 2 )
        $c[] = 'alt';

    // Separates classes with a single space, collates classes for comment LI
    $c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

    // Tada again!
    return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function quentin_date_classes( $t, &$c, $p = '' ) {
    $t = $t + ( get_option('gmt_offset') * 3600 );
    $c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
    $c[] = $p . 'm' . gmdate( 'm', $t ); // Month
    $c[] = $p . 'd' . gmdate( 'd', $t ); // Day
    $c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function quentin_cats_meow($glue) {
    $current_cat = single_cat_title( '', false );
    $separator = "\n";
    $cats = explode( $separator, get_the_category_list($separator) );
    foreach ( $cats as $i => $str ) {
        if ( strstr( $str, ">$current_cat<" ) ) {
            unset($cats[$i]);
            break;
        }
    }
    if ( empty($cats) )
        return false;

    return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function quentin_tag_ur_it($glue) {
    $current_tag = single_tag_title( '', '',  false );
    $separator = "\n";
    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
    foreach ( $tags as $i => $str ) {
        if ( strstr( $str, ">$current_tag<" ) ) {
            unset($tags[$i]);
            break;
        }
    }
    if ( empty($tags) )
        return false;

    return trim(join( $glue, $tags ));
}

// Produces an avatar image with the hCard-compliant photo class
function quentin_commenter_link() {
    $commenter = get_comment_author_link();
    if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
        $commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
    } else {
        $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
    }
    $avatar_email = get_comment_author_email();
    $avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
    echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Function to filter the default gallery shortcode
function quentin_gallery($attr) {
    global $post;
    if ( isset($attr['orderby']) ) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if ( !$attr['orderby'] )
            unset($attr['orderby']);
    }

    extract(shortcode_atts( array(
        'orderby'    => 'menu_order ASC, ID ASC',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
    ), $attr ));

    $id           =  intval($id);
    $orderby      =  addslashes($orderby);
    $attachments  =  get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

    if ( empty($attachments) )
        return null;

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $id => $attachment )
            $output .= wp_get_attachment_link( $id, $size, true ) . "\n";
        return $output;
    }

    $listtag     =  tag_escape($listtag);
    $itemtag     =  tag_escape($itemtag);
    $captiontag  =  tag_escape($captiontag);
    $columns     =  intval($columns);
    $itemwidth   =  $columns > 0 ? floor(100/$columns) : 100;

    $output = apply_filters( 'gallery_style', "\n" . '<div class="gallery">', 9 ); // Available filter: gallery_style

    foreach ( $attachments as $id => $attachment ) {
        $img_lnk = get_attachment_link($id);
        $img_src = wp_get_attachment_image_src( $id, $size );
        $img_src = $img_src[0];
        $img_alt = $attachment->post_excerpt;
        if ( $img_alt == null )
            $img_alt = $attachment->post_title;
        $img_rel = apply_filters( 'gallery_img_rel', 'attachment' ); // Available filter: gallery_img_rel
        $img_class = apply_filters( 'gallery_img_class', 'gallery-image' ); // Available filter: gallery_img_class

        $output  .=  "\n\t" . '<' . $itemtag . ' class="gallery-item gallery-columns-' . $columns .'">';
        $output  .=  "\n\t\t" . '<' . $icontag . ' class="gallery-icon"><a href="' . $img_lnk . '" title="' . $img_alt . '" rel="' . $img_rel . '"><img src="' . $img_src . '" alt="' . $img_alt . '" class="' . $img_class . ' attachment-' . $size . '" /></a></' . $icontag . '>';

        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "\n\t\t" . '<' . $captiontag . ' class="gallery-caption">' . $attachment->post_excerpt . '</' . $captiontag . '>';
        }

        $output .= "\n\t" . '</' . $itemtag . '>';
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= "\n</div>\n" . '<div class="gallery">';
    }
    $output .= "\n</div>\n";

    return $output;
}



// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function quentin_widgets_init() {
    if ( !function_exists('register_sidebars') )
        return;

    // Formats the Quentin widgets, adding readability-improving whitespace
    $p = array(
        'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
        'after_widget'   =>   "\n\t\t\t</li>\n",
        'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
        'after_title'    =>   "</h3>\n"
    );

    // Table for how many? Two? This way, please.
    register_sidebars( 1, $p );
}


// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'quentin_widgets_init' );

// Registers our function to filter default gallery shortcode
//add_filter( 'post_gallery', 'quentin_gallery', $attr );

// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// EDITS THE EXCEPT
function gpp_excerpt($text) {
    return str_replace('[...]', '<a href="'.get_permalink().'">Continue Reading &rarr;</a>', $text);
}

add_filter('the_excerpt', 'gpp_excerpt');

function new_excerpt_length($length) {
    return 20;
}

add_filter('excerpt_length', 'new_excerpt_length');
