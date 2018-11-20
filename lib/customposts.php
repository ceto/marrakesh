<?php

// Register Custom Post Type
function marrakesh_custom_post_type() {

    $labels = array(
        'name'                  => _x( 'References', 'Post Type General Name', 'marrakesh' ),
        'singular_name'         => _x( 'Reference', 'Post Type Singular Name', 'marrakesh' ),
        'menu_name'             => __( 'Reference', 'marrakesh' ),
        'name_admin_bar'        => __( 'Reference', 'marrakesh' ),
        'archives'              => __( 'Item Archives', 'marrakesh' ),
        'attributes'            => __( 'Item Attributes', 'marrakesh' ),
        'parent_item_colon'     => __( 'Parent Item:', 'marrakesh' ),
        'all_items'             => __( 'All References', 'marrakesh' ),
        'add_new_item'          => __( 'Add New Item', 'marrakesh' ),
        'add_new'               => __( 'Add New', 'marrakesh' ),
        'new_item'              => __( 'New Item', 'marrakesh' ),
        'edit_item'             => __( 'Edit Item', 'marrakesh' ),
        'update_item'           => __( 'Update Item', 'marrakesh' ),
        'view_item'             => __( 'View Reference', 'marrakesh' ),
        'view_items'            => __( 'View References', 'marrakesh' ),
        'search_items'          => __( 'Search Reference', 'marrakesh' ),
        'not_found'             => __( 'Not found', 'marrakesh' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'marrakesh' ),
        'featured_image'        => __( 'Featured Image', 'marrakesh' ),
        'set_featured_image'    => __( 'Set featured image', 'marrakesh' ),
        'remove_featured_image' => __( 'Remove featured image', 'marrakesh' ),
        'use_featured_image'    => __( 'Use as featured image', 'marrakesh' ),
        'insert_into_item'      => __( 'Insert into item', 'marrakesh' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'marrakesh' ),
        'items_list'            => __( 'Items list', 'marrakesh' ),
        'items_list_navigation' => __( 'Items list navigation', 'marrakesh' ),
        'filter_items_list'     => __( 'Filter items list', 'marrakesh' ),
    );
    $args = array(
        'label'                 => __( 'Reference', 'marrakesh' ),
        'description'           => __( 'Post Type Description', 'marrakesh' ),
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
                    'rewrite' => array( 'slug' => 'references' )
    ));
}

add_action( 'init', 'marrakesh_add_reference_taxonomies' );