<?php
/*
Plugin Name: WP Add Google Analytics Link Header
Description: Basic WordPress Plugin To Add Google Analytics Link to header
Version:     1.0.0
License:     GPL2

Add Google Analytics Link Header is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Add Google Analytics Link Header is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Add Google Analytics Link Header. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
*/

function dwwp_add_googleAnalyticsLink() {
    global $wp_admin_bar;
//    echo '<PRE>';
//    var_dump($wp_admin_bar);

    // Adding Menu
    // see https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu
    $wp_admin_bar->add_menu(array(
        'id' => 'google_analytics',
        'title' => 'Google Analytics',
        'href' => 'http://google.com/analytics'
    ));
}

add_action('wp_before_admin_bar_render', dwwp_add_googleAnalyticsLink);