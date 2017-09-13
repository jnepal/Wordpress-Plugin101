<?php
/*
Plugin Name: WP Remove News Box
Description: Basic WordPress Plugin To Remove Wordpress News
Version:     1.0.0
License:     GPL2

Remove News Box is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Remove News Box is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Remove News Box. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
*/

function dwwp_remove_dashboard_widget() {
    // see https://codex.wordpress.org/Function_Reference/remove_meta_box
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
}

add_action('wp_dashboard_setup', 'dwwp_remove_dashboard_widget');