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
    

function projfilter_class( $class = '', $post_id = null ) {
    echo 'class="' . join( ' ', get_projfilter_class( $class, $post_id ) ) . '"';
}


function get_projfilter_class( $class = '', $post_id = null ) {
	$post = get_post( $post_id );

	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	if ( ! $post ) {
		return $classes;
	}

	$classes[] = 'referencegrid__item--' . $post->ID;


	// All public taxonomies
    $taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
    
	foreach ( (array) $taxonomies as $taxonomyobject ) {
        $taxonomy=$taxonomyobject->name;
        $taxonomyslug=$taxonomyobject->rewrite['slug'];
		if ( is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
			foreach ( (array) get_the_terms( $post->ID, $taxonomy ) as $term ) {
				if ( empty( $term->slug ) ) {
					continue;
				}

				$term_class = sanitize_html_class( $term->slug, $term->term_id );
				if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
					$term_class = $term->term_id;
				}

				// 'post_tag' uses the 'tag' prefix for backward compatibility.
				if ( 'post_tag' == $taxonomy ) {
					$classes[] = 'tag-' . $term_class;
				} else {
					$classes[] = sanitize_html_class( $term_class, $taxonomyslug . '--' . $term->term_id );
                }
                //var_dump($taxonomyslug);                
			}
		}
	}

	$classes = array_map( 'esc_attr', $classes );

	$classes = apply_filters( 'post_class', $classes, $class, $post->ID );

	return array_unique( $classes );
}


function marrakesh_modify_num_references($query) {
    if ( ($query->is_main_query()) && ( ($query->is_post_type_archive('reference')) || ($query->is_tax('reference-type')) ) && ( !is_admin() ) ) {
      $query->set('posts_per_page', -1);
      $query->set('orderby', 'menu_order');
      $query->set('order', 'ASC');
      $query->set('post_status', array('publish' ));
    }
}
add_action('pre_get_posts', 'marrakesh_modify_num_references');