<?php
/**
 * For sidebar menu
 */

// Custom Post Type
// see http://justintadlock.com/archives/2010/04/29/custom-post-types-in-wordpress
function dwwp_register_post_type() {
    $singular = 'Job Listing';
    $plural = 'Job Listing';

    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'add_name'              => 'Add New',
        'add_name_item'         => 'Add New ' . $singular,
        'edit'                  => 'Edit',
        'edit_item'             => 'Edit ' . $singular,
        'new_item'              => 'New ' . $singular,
        'view'                  => 'View',
        'view_item'             => 'View ' . $singular,
        'search_term'           => 'Search ' . $singular,
        'parent'                => 'Parent' . $singular,
        'not_found'             => 'No ' . $plural . 'found',
        'not_found_in_trash'    => 'No ' . $plural . 'in Trash'

    );

    // For side bar section
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true, // excludes from wordpress loop
        'exclude_from_search'   => false,
        'show_in_nav_menus'     => true, // List label in Appearance->Menus and allows to add this as a menu
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true, // if true lists label Under Top Nav +New Section
        'menu_position'         => 10,
        'menu_icon'             => 'dashicons-businessman',
        'can_export'            => true,
        'delete_with_user'      => false,
        'hierarchical'          => false, // if set to true acts like a page or categories with parent - children relationship else acts like a post that don't have no relationship
        'has_archive'           => true, // if set to true allows the slug to change (custom slug) when people searches; here we have job as a slug
        'query_var'             => true,
        'capability_type'       => 'post', // Who have access to this custom post type. we have listed the user who could post (editor, contributor) can have access. if sets to 'page' , only editor and administrator have access to it
        'map_meta_cap'          => true,
        'rewrite'               => array(
            'slug' => 'jobs',
            'with_front' => true,
            'pages' => true,
            'feeds' => false, // if set to false doesn't list in rss fed
        ),
        // Allows which default input fields type show up
        'supports' => array(
            'title',
//            'editor',
//            'author',
//            'custom-fields'
        )
    );



    // see https://codex.wordpress.org/Function_Reference/register_post_type
    register_post_type('job', $args);
}

add_action('init', 'dwwp_register_post_type');

/**
 * Custom Taxonomy
 * Allows user to filter jobs by location
 * Taxonomy is like categories, tags for tags
 */
function  dwwp_register_taxonomy() {
    $singular = 'Location';
    $plural = 'Locations';

    $labels = array(
        'name'                       => $plural,
        'singular_name'              => $singular,
        'search_items'               => 'Search ' . $plural,
        'popular_items'              => 'Popular ' . $plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $singular,
        'update_item'                => 'Update ' . $singular,
        'add_new_item'               => 'Add New ' . $singular,
        'new_item_name'              => 'New' . $singular . 'Name',
        'separate_items_with_commas' => 'Seperate ' . $plural. 'With commas',
        'add_or_remove_items'        => 'Add or remove ' . $plural,
        'choose_from_most_used'      => 'Choose from the most used' . $plural,
        'not_found'                  => 'No ' . $plural . 'found',
        'menu_name'                  => $plural
    );

    $args = array(
        'hierarchical' => true, // enables parent-child realtionship
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => 'location')
    );
    // See https://developer.wordpress.org/reference/functions/register_taxonomy/
    register_taxonomy('location', 'job', $args);
}

add_action('init', 'dwwp_register_taxonomy');