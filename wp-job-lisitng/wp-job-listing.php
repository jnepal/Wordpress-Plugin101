<?php
/*
Plugin Name: WP Job Listing
Description: A Simple Plugin that helps to CRUD the job
Version:     1.0
License:     GPL2

WP Job Listing is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Job Listing is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Job Listing. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'wp-job-custom-post-types.php');
require_once (plugin_dir_path(__FILE__) . 'wp-job-fields.php');
require_once (plugin_dir_path(__FILE__) . 'wp-job-setting.php');
require_once (plugin_dir_path(__FILE__) . 'wp-job-shortcode.php');

function dwwp_admin_enqueue_scripts() {
    global $pagenow, $typenow;

     if ( $typenow == 'job' ) {
         wp_enqueue_style( 'dwwp-admin-jobs-css', plugins_url( 'css/admin-jobs.css', __FILE__ ));
     }
    // load only on 'post.php' and 'post-new.php' page with custom post type 'job'

    if ( ($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job' ) {
        wp_enqueue_script( 'dwwp-job-js', plugins_url( 'js/admin-jobs.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '1.0', true );
        wp_enqueue_script( 'dwwp-custom-quicktags', plugins_url( 'js/dwwp-quicktags.js', __FILE__ ), array( 'quicktags' ), '1.0d', true );
        wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
    }

    if ( $pagenow == 'edit.php' && $typenow == 'job' ) {
        wp_enqueue_script( 'dwwp-reorder-js', plugins_url( 'js/reorder.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '1.0', true );

        // to make php variable available for use in javascript
        // see https://codex.wordpress.org/Function_Reference/wp_localize_script
        wp_localize_script('dwwp-reorder-js', 'WP_JOB_LISTING', array(
            'security' => wp_create_nonce('wp-job-order'),
            'success' => __('Jobs sort order has been updated'),
            'error' => __('There was error saving the sort order, or you do not have proper permission')
        ));
    }
}

add_action('admin_enqueue_scripts', 'dwwp_admin_enqueue_scripts');

