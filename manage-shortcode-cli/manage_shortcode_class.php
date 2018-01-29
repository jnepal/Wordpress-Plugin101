<?php
namespace Manage_Shortcodes_CLI;

class Manage_Shortcodes extends \WP_CLI_Command {
    /**
     * Returns a list of registered Shortcodes.
     *
     * ## OPTIONS
     * <name>
     * : What is your name
     *
     * [<other-name>]
     * : This is another optional name
     *
     * --myname=<my-name>
     * : A required flag name
     *
     * [--options-name=<my-name>]
     * : An optional flag name
     *
     * ## EXAMPLES
     * wp shortcodes list_registered_shortcodes test --my-name=test
     *
     * @synopsis <name> [<other-name>] --my_name=<my-name> [--my_name=<my-name>]
     *
     * @subcommand list
     * @alias list
     */
    public function list_registered_shortcodes( $args, $assoc_args ) {
        /**
         * $args gives the list of arguments provided
         * $assoc_args returns arguments provided for flag
         * for example for command wp shortcodes list_registered_shortcodes test --my-name=test
         * $args returns test
         * $assoc_args['my-name'] returns test
         */

        /**
         * Setting Default arguments
         */
        $default_args = array( 'my_name' => 'Bruce Wayne' );
        $assoc_args = wp_parse_args( $assoc_args, $default_args );


        \WP_CLI::success('Rewrite rules flushed');
    }
}
\WP_CLI::add_command( 'shortcodes', __NAMESPACE__ . '\Manage_Shortcodes' ); // Maps shrotcodes command to the this class