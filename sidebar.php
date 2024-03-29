<div class="sidebar span-5 last">
    <div id="primary">
        <ul class="sidebars">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // begin primary sidebar widgets ?>

            <li id="pages">
                <h3><?php _e( 'Pages', 'quentin' ) ?></h3>
                <ul>
                    <?php wp_list_pages('title_li=&sort_column=menu_order' ) ?>
                </ul>
            </li>

            <li id="categories">
                <h3><?php _e( 'Categories', 'quentin' ) ?></h3>
                <ul>
                    <?php wp_list_categories('title_li=&show_count=0&hierarchical=1') ?> 
                </ul>
            </li>

            <li id="archives">
                <h3><?php _e( 'Archives', 'quentin' ) ?></h3>
                <ul>
                    <?php wp_get_archives('type=monthly') ?>
                </ul>
            </li>
        <?php endif; // end primary sidebar widgets  ?>
        </ul>
    </div><!-- #primary  -->
</div>
