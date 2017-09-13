<?php
/*
Plugin Name: WP Likebox
Description: Simple Plugin to show Facebook wp-likebox
Version:     1.0
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Add javascript
function add_scripts() {
    wp_enqueue_script('wp-likebox-scripts', plugins_url().'/wp-likebox/js/wp-likebox.js', false);
}

add_action('wp_enqueue_scripts', 'add_scripts');

// Include Class
include('class.likebox.php');

// Register Widget
function register_likebox() {
    register_widget('Likebox_Widget');
}

add_action('widgets_init', 'register_likebox');