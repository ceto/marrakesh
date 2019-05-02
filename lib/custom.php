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


function reffilter_class( $class = '', $post_id = null ) {
    echo 'class="' . join( ' ', get_reffilter_class( $class, $post_id ) ) . '"';
}


function get_reffilter_class( $class = '', $post_id = null ) {
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







	/**
	 * Widget rating filter class.
	 */
	class WC_Widget_Status_Filter extends WC_Widget {
		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce widget_status_filter';
			$this->widget_description = __( 'Display a list of additional options to filter products in your store.', 'woocommerce' );
			$this->widget_id          = 'woocommerce_status_filter';
			$this->widget_name        = __( 'Filter Products by Status', 'woocommerce' );
			$this->settings           = array(
				'title' => array(
					'type'  => 'text',
					'std'   => __( 'Show', 'woocommerce' ),
					'label' => __( 'Title', 'woocommerce' ),
				),
			);
			parent::__construct();
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 * @param array $args     Arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			if ( ! is_shop() && ! is_product_taxonomy() ) {
				return;
			}

			$availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); // WPCS: input var ok, CSRF ok.
      //print_r($availability_filter);
			$this->widget_start( $args, $instance );

			echo '<ul class="woocommerce-widget-layered-nav-list">';

			$class       = $availability_filter ? 'wc-availability-in-stock chosen' : 'wc-availability-in-stock';
			$link        = apply_filters( 'woocommerce_availability_filter_link', ! $availability_filter ? add_query_arg( 'filter_availability', 'in_stock' ) : remove_query_arg( 'filter_availability' ) );
			$rating_html = 'Hide out of stock items';
			$count_html  = ''; ////////// ADD COUNT LATER

			printf( '<li class="%s"><a href="%s">%s</a> %s</li>', esc_attr( $class ), esc_url( $link ), $rating_html, $count_html ); // WPCS: XSS ok.

			echo '</ul>';

			$this->widget_end( $args );
		}
	} // end class WC_Widget_Status_Filter extends WC_Widget


  add_action( 'widgets_init', function(){
    register_widget( 'WC_Widget_Status_Filter' );
  });



  class TabWalker extends Walker_Nav_Menu {
    private $cpt; // Boolean, is current post a custom post type
    private $archive; // Stores the archive page for current URL

    public function __construct() {
      add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
      add_filter('nav_menu_item_id', '__return_null');
      $cpt           = get_post_type();
      $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
      $this->archive = get_post_type_archive_link($cpt);
    }

    public function checkCurrent($classes) {
      return preg_match('/(current[-_])|active/', $classes);
    }

    // @codingStandardsIgnoreStart
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
      $element->is_subitem = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

      if ($element->is_subitem) {
        foreach ($children_elements[$element->ID] as $child) {
          if ($child->current_item_parent || Utils\url_compare($this->archive, $child->url)) {
            $element->classes[] = 'active';
          }
        }
      }

      $element->is_active = (!empty($element->url) && strpos($this->archive, $element->url));

      if ($element->is_active) {
        $element->classes[] = 'active';
      }

      parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
    // @codingStandardsIgnoreEnd

    public function cssClasses($classes, $item) {
      $slug = sanitize_title($item->title);

      // Fix core `active` behavior for custom post types
      if ($this->cpt) {
        $classes = str_replace('current_page_parent', '', $classes);

        if ($this->archive) {
          if (Utils\url_compare($this->archive, $item->url)) {
            $classes[] = 'active';
          }
        }
      }

      // Remove most core classes
      $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'is-active', $classes);
      $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

      // Re-add core `menu-item` class
      $classes[] = 'tabs-title';

      // Re-add core `menu-item-has-children` class on parent elements
      if ($item->is_subitem) {
        $classes[] = 'menu-item-has-children';
      }

      // Add `menu-<slug>` class
      $classes[] = 'tabs-' . $slug;

      $classes = array_unique($classes);
      $classes = array_map('trim', $classes);

      return array_filter($classes);
    }
  }