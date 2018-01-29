<?php
/*
Plugin Name: Manage Shortcode ClI
Description: Simple Plugin for wp-cli
Version:     1.0
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

namespace Manage_Shortcodes_CLI;

/***
 * Useful Golbal Constants
 */
define( 'MG_SHORTCODES_VERSION', '0.1.0' );
define( 'MG_SHORTCODES_URL', plugin_dir_url(__FILE__) );
define( 'MG_SHORTCODES_PATH', dirname(__FILE__) . '/' );

// Check if WP_CLI is defined and include only when WP_CLI is defined
// Requires installation of wp-cli. see www.wp-cli.org
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require_once( dirname( __FILE__ ) . '/manage_shortcode_class.php');
}

