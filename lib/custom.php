<?php

add_filter('acf/settings/remove_wp_meta_box', '__return_false');


add_filter('widget_nav_menu_args', 'marrakesh_menu_widget_args'); //for menus in widgets
function marrakesh_menu_widget_args($args) {
    return array_merge( $args, array(
        'items_wrap' => '<ul class="%2$s menu--side vertical">%3$s</ul>'
    ) );
}


/** Create Options Pages */

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
		'page_title' 	=> 'Globals',
		'menu_title'	=> 'Globals',
        'menu_slug' 	=> 'globals',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
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

    if ( get_field('largethumb', $post ) == 1 ) {
        $classes[]='referencegrid__item--large';
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

  add_filter( 'tiny_mce_before_init', 'marrakesh_tinymce_add_pre' );
  function marrakesh_tinymce_add_pre( $initArray ) {
   // Command separated string of extended elements
   $ext = 'svg[preserveAspectRatio|class|style|version|viewbox|xmlns],defs,use[xlink?href|x|y],linearGradient[id|x1|y1|z1]';

    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    // maybe; set tiny paramter verify_html
    //$initArray['verify_html'] = false;

    return $initArray;
  }

// define the wp_kses_allowed_html callback
function marrakesh_add_tags_to_wp_kses_allowed_html( $array ) {
    $svg_args = array(
        'svg' => array('class' => true),
        'use' => array( 'xlink:href' => true )
    );
    $array = array_merge( $array, $svg_args );
    return $array;
};

// add the filter
add_filter( 'wp_kses_allowed_html', 'marrakesh_add_tags_to_wp_kses_allowed_html', 10, 1 );

function blockgrid_gallery( $output, $atts, $instance ) {
    $atts = shortcode_atts( array(
      'order'   => 'ASC',
      'orderby' => 'menu_order ID',
      'id'      => get_the_ID(),
      'columns' => 3,
      'size'    => 'thumbnail',
      'include' => '',
      'exclude' => '',
      ), $atts );

    $atts[ 'columns' ] = 3;

    if ( ! empty( $atts['include'] ) ) {
      $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
      }
    } elseif ( ! empty( $atts['exclude'] ) ) {
      $attachments = get_children( array( 'post_parent' => intval( $atts[ 'id' ] ), 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
      $attachments = get_children( array( 'post_parent' => intval( $atts[ 'id' ] ), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) )
      return '';
    $galleryid='psgallery-'.rand(10,99);

    $output = '<div id="'.$galleryid.'" class="psgallery psgallery--incontent grid-x grid-margin-x grid-margin-y small-up-2 medium-up-2 tablet-up-3 large-up-2 xlarge-up-' . intval( $atts[ 'columns' ] ) .'" itemscope itemtype="http://schema.org/ImageGallery">';
    $i=0;
    foreach ( $attachments as $id => $attachment ) {
      $img        = wp_get_attachment_image_url( $id, $atts[ 'size' ] );
      $thumb      = wp_get_attachment_image_src( $id, $atts[ 'size' ] );
      $img_srcset = wp_get_attachment_image_srcset( $id, $atts[ 'size' ] );
      $img_full   = wp_get_attachment_image_url( $id, 'xlarge' );
      $image      = wp_get_attachment_image_src( $id, 'xlarge' );

      $caption = ( ! $attachment->post_excerpt ) ? '' : ' data-caption="' . esc_attr( $attachment->post_excerpt ) . '" ';
      $imgtitle = ( ! $attachment->post_excerpt ) ? '' : ' data-title="' . esc_attr( $attachment->post_excerpt ) . '" ';


        $ratio=100;
        if ($thumb) {
            $ratio = $thumb[2] / $thumb[1] * 100;
        }


      $output .= '<figure class="cell psgallery__item" data-aos="fade-up-small" data-aos-delay="'. ($i++ % 5) * 100 .'" data-aos-anchor="#'.$galleryid.'" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">'
        . '<a href="' . esc_url( $img_full ) . '" class="thumbnail" itemprop="contentUrl" '.$caption.' '.$imgtitle.'" data-size="'.$image['1'].'x'.$image['2'].'" style="padding-bottom: '.$ratio.'%">'
        . '<img width="'.$thumb['1'].'" height="'.$thumb['2'].'" src="' . esc_url( $img ) . '" ' . $caption . ' itemprop="thumbnail" alt="' . esc_attr( $attachment->title ) . '"  srcset="' . esc_attr( $img_srcset ) . '" sizes="(max-width: 50em) 87vw, 680px" />'
        . '</a>';
        $output .= (! $attachment->post_excerpt) ? '' : '<figcaption>'.esc_attr( $attachment->post_excerpt ).'</figcaption>';
        $output .= '</figure>';
    }

    $output .= '</div>';
    //$output .= file_get_contents(get_stylesheet_directory_uri() . '/templates/photoswipedom.php');
    $output.='
  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
          <div class="pswp__container">
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
          </div>
          <div class="pswp__ui pswp__ui--hidden">

              <div class="pswp__top-bar">
                  <div class="pswp__counter"></div>
                  <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                  <button class="pswp__button pswp__button--share" title="Share"></button>
                  <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                  <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                  <div class="pswp__preloader">
                      <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                          <div class="pswp__preloader__donut"></div>
                        </div>
                      </div>
                  </div>
              </div>

              <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                  <div class="pswp__share-tooltip"></div>
              </div>

              <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
              </button>

              <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
              </button>

              <div class="pswp__caption">
                  <div class="pswp__caption__center"></div>
              </div>

          </div>
      </div>
  </div>

    ';

    return $output;
  }
  add_filter( 'post_gallery', 'blockgrid_gallery', 10, 3 );




  function marrakesh_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'thumbwide' => __( 'Thumbnail (16x9)', 'marrakesh'),
        'thumbnail' => __( 'Thumbnail (1x1)', 'marrakesh')
    ) );
}

add_filter( 'image_size_names_choose', 'marrakesh_custom_image_sizes' );


function marrakesh_add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'marrakesh_add_style_select_buttons' );

//add custom styles to the WordPress editor
function marrakesh_custom_editor_styles( $init_array ) {
    $style_formats = array(
        array(
            'title' => 'Button',
            'inline' => 'a',
            'selector' => 'a',
            'classes' => 'button',
            'wrapper' => false,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;
}
add_filter( 'tiny_mce_before_init', 'marrakesh_custom_editor_styles' );

function marrakesh_product_cat( $record ) {
    $images = array();

    $pics = array('template', 'covera', 'coverb' );
    foreach ( $pics as $pic ) {
        $theimg = get_field($pic, $record['taxonomy'] . '_' . $record['term_id']);
        $info = wp_get_attachment_image_src($theimg['ID'], 'thumbnail' );
        if ( ! $info ) {
            continue;
        }
        $images[ $pic ] = array(
            'url'    => $info[0],
            'width'  => $info[1],
            'height' => $info[2],
        );
    }
    $record['images'] = (array) apply_filters( 'algolia_get_post_images', $images );
    return $record;
}
add_filter( 'algolia_term_product_cat_record', 'marrakesh_product_cat');

function marrakesh_algolia_post_atts( array $attributes, WP_Post $post ) {
    $attributes['post_excerpt'] = get_the_excerpt($post->ID);
    return $attributes;
}
add_filter( 'algolia_post_shared_attributes', 'marrakesh_algolia_post_atts', 10, 2 );
add_filter( 'algolia_searchable_post_shared_attributes', 'marrakesh_algolia_post_atts', 10, 2 );


function marrakesh_algolia_product_atts( array $attributes, WP_Post $post ) {
    $attributes['stock_status'] = get_post_meta( $post->ID, '_stock_status', true );
    $attributes['stock'] = (int) get_post_meta( $post->ID, '_stock', true );
    return $attributes;
}
add_filter( 'algolia_post_product_shared_attributes', 'marrakesh_algolia_product_atts', 10, 2 );
add_filter( 'algolia_searchable_post_product_shared_attributes', 'marrakesh_algolia_product_atts', 10, 2 );

function marrakesh_algolia_product_index_settings( array $settings ) {
    $settings['attributesToIndex'][] = 'unordered(post_excerpt)';
    $settings['attributesToSnippet'][] = 'post_excerpt:30';

    // By default, the plugin uses 'is_sticky' and the 'post_date' in the custom ranking.
    // Here we retrieve the custom ranking so that we can alter it with more control.
    $customRanking = $settings['customRanking'];

    // We add our custom ranking rule at the beginning of the rules so that
    // it is the first one considered in the algorithm.
    array_unshift( $customRanking, 'desc(stock)' );

    // We override the initial custom ranking rules.
    $settings['customRanking'] = $customRanking;

    return $settings;
}
add_filter( 'algolia_posts_product_index_settings', 'marrakesh_algolia_product_index_settings' );

add_filter( 'algolia_searchable_post_types', function( $post_types ) {
    $post_types = array('product');
    return $post_types;
});

add_filter( 'yith_wcwl_main_script_deps', function() {
    return array( 'jquery' );
});

function marrakesh_remove_unnecessary_scripts() {
    // wp_dequeue_script( 'jquery-selectBox' );
    // wp_deregister_script( 'jquery-selectBox' );
    // wp_dequeue_script( 'prettyPhoto' );
    // wp_deregister_script( 'prettyPhoto' );
    wp_dequeue_script( 'jquery-yith-wcwl' );
    wp_deregister_script( 'jquery-yith-wcwl' );

}
add_action( 'wp_print_scripts', 'marrakesh_remove_unnecessary_scripts' );

function marrakesh_remove_unnecessary_styles() {
    wp_dequeue_style( 'yith-wcwl-main' );
    wp_deregister_style( 'yith-wcwl-main' );
}
add_action( 'wp_print_styles', 'marrakesh_remove_unnecessary_styles' );

function marrakesh_get_current_url() {
    $url =  isset($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";

    $url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $url;
}
