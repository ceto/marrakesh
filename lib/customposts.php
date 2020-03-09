<?php

// Register Custom Post Type
function marrakesh_custom_post_type() {

    $labels = array(
        'name'                  => _x( 'References', 'Post Type General Name', 'marrakeshadmin' ),
        'singular_name'         => _x( 'Reference', 'Post Type Singular Name', 'marrakeshadmin' ),
        'menu_name'             => __( 'Works & Galleries', 'marrakeshadmin' ),
        'name_admin_bar'        => __( 'Reference', 'marrakeshadmin' ),
        'archives'              => __( 'Item Archives', 'marrakeshadmin' ),
        'attributes'            => __( 'Item Attributes', 'marrakeshadmin' ),
        'parent_item_colon'     => __( 'Parent Item:', 'marrakeshadmin' ),
        'all_items'             => __( 'All References', 'marrakeshadmin' ),
        'add_new_item'          => __( 'Add New Item', 'marrakeshadmin' ),
        'add_new'               => __( 'Add New Reference', 'marrakeshadmin' ),
        'new_item'              => __( 'New Item', 'marrakeshadmin' ),
        'edit_item'             => __( 'Edit Item', 'marrakeshadmin' ),
        'update_item'           => __( 'Update Item', 'marrakeshadmin' ),
        'view_item'             => __( 'View Reference', 'marrakeshadmin' ),
        'view_items'            => __( 'View References', 'marrakeshadmin' ),
        'search_items'          => __( 'Search Reference', 'marrakeshadmin' ),
        'not_found'             => __( 'Not found', 'marrakeshadmin' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'marrakeshadmin' ),
        'featured_image'        => __( 'Featured Image', 'marrakeshadmin' ),
        'set_featured_image'    => __( 'Set featured image', 'marrakeshadmin' ),
        'remove_featured_image' => __( 'Remove featured image', 'marrakeshadmin' ),
        'use_featured_image'    => __( 'Use as featured image', 'marrakeshadmin' ),
        'insert_into_item'      => __( 'Insert into item', 'marrakeshadmin' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'marrakeshadmin' ),
        'items_list'            => __( 'Items list', 'marrakeshadmin' ),
        'items_list_navigation' => __( 'Items list navigation', 'marrakeshadmin' ),
        'filter_items_list'     => __( 'Filter items list', 'marrakeshadmin' ),
    );
    $args = array(
        'label'                 => __( 'Reference', 'marrakeshadmin' ),
        'description'           => __( 'Post Type Description', 'marrakeshadmin' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields', 'excerpt' ),
        'taxonomies'            => array( 'reference-type'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-images-alt2',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'reference', $args );

    // helper galleries
    $labels = array(
        'name'                  => _x( 'Galleries', 'Post Type General Name', 'marrakeshadmin' ),
        'singular_name'         => _x( 'Gallery', 'Post Type Singular Name', 'marrakeshadmin' ),
        'menu_name'             => __( 'Gallery', 'marrakeshadmin' ),
        'name_admin_bar'        => __( 'Gallery', 'marrakeshadmin' ),
        'archives'              => __( 'Item Archives', 'marrakeshadmin' ),
        'attributes'            => __( 'Item Attributes', 'marrakeshadmin' ),
        'parent_item_colon'     => __( 'Parent Item:', 'marrakeshadmin' ),
        'all_items'             => __( 'Galleries', 'marrakeshadmin' ),
        'add_new_item'          => __( 'Add New Item', 'marrakeshadmin' ),
        'add_new'               => __( 'Add New Gallery', 'marrakeshadmin' ),
        'new_item'              => __( 'New Item', 'marrakeshadmin' ),
        'edit_item'             => __( 'Edit Item', 'marrakeshadmin' ),
        'update_item'           => __( 'Update Item', 'marrakeshadmin' ),
        'view_item'             => __( 'View Gallery', 'marrakeshadmin' ),
        'view_items'            => __( 'View Galleries', 'marrakeshadmin' ),
        'search_items'          => __( 'Search Gallery', 'marrakeshadmin' ),
        'not_found'             => __( 'Not found', 'marrakeshadmin' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'marrakeshadmin' ),
        'featured_image'        => __( 'Featured Image', 'marrakeshadmin' ),
        'set_featured_image'    => __( 'Set featured image', 'marrakeshadmin' ),
        'remove_featured_image' => __( 'Remove featured image', 'marrakeshadmin' ),
        'use_featured_image'    => __( 'Use as featured image', 'marrakeshadmin' ),
        'insert_into_item'      => __( 'Insert into item', 'marrakeshadmin' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'marrakeshadmin' ),
        'items_list'            => __( 'Items list', 'marrakeshadmin' ),
        'items_list_navigation' => __( 'Items list navigation', 'marrakeshadmin' ),
        'filter_items_list'     => __( 'Filter items list', 'marrakeshadmin' ),
    );
    $args = array(
        'label'                 => __( 'Gallery', 'marrakeshadmin' ),
        'description'           => __( 'Post Type Description', 'marrakeshadmin' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => 'edit.php?post_type=reference',
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-images-alt2',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'gallery', $args );

}
add_action( 'init', 'marrakesh_custom_post_type', 0 );


function marrakesh_add_reference_taxonomies(){

    $category_labels = array(
        'name' => __( 'Reference Categories', 'brick'),
        'singular_name' => __( 'Reference Category', 'brick'),
        'search_items' =>  __( 'Search Reference Categories', 'brick'),
        'all_items' => __( 'All Reference Categories', 'brick'),
        'parent_item' => __( 'Parent Reference Category', 'brick'),
        'edit_item' => __( 'Edit Reference Category', 'brick'),
        'update_item' => __( 'Update Reference Category', 'brick'),
        'add_new_item' => __( 'Add New Reference Category', 'brick'),
        'menu_name' => __( 'Reference Categories', 'brick')
    );

    register_taxonomy("reference-type",
            array("reference"),
            array("hierarchical" => true,
                    'labels' => $category_labels,
                    'show_ui' => true,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => __('galeria','marrakesh') )
    ));
}

add_action( 'init', 'marrakesh_add_reference_taxonomies' );
