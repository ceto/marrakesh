<?php
// Define path and URL to the ACF plugin.
define( 'MARRAKESH_ACF_PATH', get_stylesheet_directory() . '/lib/acf/' );
define( 'MARRAKESH_ACF_URL', get_stylesheet_directory_uri() . '/lib/acf/' );

// Include the ACF plugin.
include_once( MARRAKESH_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'marrakesh_acf_settings_url');
function marrakesh_acf_settings_url( $url ) {
    return MARRAKESH_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
// add_filter('acf/settings/show_admin', 'marrakesh_acf_settings_show_admin');
// function marrakesh_acf_settings_show_admin( $show_admin ) {
//     return false;
// }

// 5. Unhide native metabox
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// 6. Save JSON
add_filter('acf/settings/save_json', 'marrakesh_acf_json_save_point');
function marrakesh_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/lib/acf/json';
    return $path;
}


// 7. Load JSON
add_filter('acf/settings/load_json', 'marrakesh_acf_json_load_point');
function marrakesh_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/lib/acf/json';
    return $paths;
}
