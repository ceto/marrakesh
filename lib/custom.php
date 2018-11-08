<?php

add_filter('acf/settings/remove_wp_meta_box', '__return_false');


add_filter('widget_nav_menu_args', 'marrakesh_menu_widget_args'); //for menus in widgets
function marrakesh_menu_widget_args($args) {
    return array_merge( $args, array(
        'items_wrap' => '<ul class="%2$s menu--side vertical">%3$s</ul>'
    ) );
}


function marrakesh_foundation_pagination() {
global $wp_query;
$big = 999999999; // need an unlikely integer
$pages = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'type'  => 'array',
    ) );
    if( is_array( $pages ) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<ul class="pagination" role="navigation" aria-label="Pagination">';
        foreach ( $pages as $page ) {
            if (strpos($page,'current')) {
                echo '<li class="current">'.strip_tags($page).'</li>';
            } elseif (strpos($page,'next')) {
                echo '<li class="pagination-next">'.$page.'</li>';
            }  elseif (strpos($page,'prev')) {
                echo '<li class="pagination-previous">'.$page.'</li>';
            } else {
                echo '<li>'.$page.'</li>';
            }
        }
        echo '</ul>';
    }
}
    