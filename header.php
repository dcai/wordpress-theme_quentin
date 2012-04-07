<!DOCTYPE html>
<html>
<head>
    <title><?php echo esc_html(get_bloginfo('name')); wp_title(); ?></title>
    <meta charset="<?php bloginfo('charset') ?>" />
    <meta name="viewport" content="width=device-width" />
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
    <!--[if IE]><link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/ie.css" type="text/css" media="screen, projection"><![endif]-->
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>"  />
    <link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
    <?php wp_head()  ?>
</head>

<body>
<div class="wrapper">
    <div class="container">
	<div id="header">
            <h1 id="blog-title"><a href="<?php echo esc_url( home_url() ); ?>/" title="<?php echo esc_html( get_option('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a></h1>
            <h3 class="description"><?php bloginfo('description') ?></h3>
	</div><!-- header -->
