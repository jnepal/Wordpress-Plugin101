<?php
/**
 * Adds the submenu
 */
function dwwp_add_submenu_page() {
    // see https://developer.wordpress.org/reference/functions/add_submenu_page/
    add_submenu_page(
        'edit.php?post_type=job', // for custom post-data
        'Reorder Jobs',
        'Reorder Jobs',
        'manage_options',
        'reorder_jobs',
        'reorder_admin_jobs_callback'
    );
}

add_action('admin_menu', 'dwwp_add_submenu_page');
function reorder_admin_jobs_callback() {
    // see https://codex.wordpress.org/Class_Reference/WP_Query
    // for performance see https://10up.github.io/Engineering-Best-Practices/php/#performance
    $args = array(
        'post_type'              => 'job',
        'orderby'                => 'menu_order',
        'order'                  => 'ASC',
        'post_status'            => 'publish',
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'post_per_page'          => 50

    );

    $jobListing = new WP_Query($args);

    ?>
    <div id="job-sort" class="wrap">
        <div id="icon-job-admin" class="icon32"><br></div>
            <h2>
                <?php _e('Sort Job Positions', 'wp-job-listing')?>
                <img src="<?php echo esc_url(admin_url(). '/images/loading.gif' )?>" id="loading-animation" alt="loading-animation">
            </h2>
                <?php if ($jobListing->have_posts()) { ?>
                    <p><?php _e('<strong>Note:</strong> This only affects the Jobs listed using the short code function.') ?></p>

                    <ul id="custom-type-list">
                        <?php while($jobListing->have_posts()) :
                            $jobListing->the_post();
                        ?>
                        <li id="<?php esc_attr(the_id()); ?>"><?php esc_html(the_title()); ?></li>
                        <?php endwhile; ?>
                    </ul>
                <?php } else { ?>
                    <p><?php _e('You have no Jobs to sort.', 'wp-job-listing'); ?></p>
                <?php } ?>
    </div>
    <?php

    /**
     * Handles the ajax post request
     */
    function dwwwp_save_reorder() {
        // Check Nonce for ajax request
        if (!check_ajax_referer('dwwp_job_order', 'security')) {
            // see https://codex.wordpress.org/Function_Reference/wp_send_json_error
            return wp_send_json_error('Invalid Nonce');
        }

        //Check for User Permission
        // see https://codex.wordpress.org/Roles_and_Capabilities
        if (!current_user_can('manage_options')) {
            return wp_send_json_error('You are not allowed to do this.');
        }

        // ajax request data
        $order = $_POST['order'];
        $counter = 0;
        echo 'Hello';
        die();
        foreach ($order as $item_id) {
            $post = array(
                'ID' => (int)$item_id,
                'menu_order' => $counter
            );

            // see https://codex.wordpress.org/Function_Reference/wp_update_post
            wp_update_post($post);
            $counter++;
        }

        // Send Success Message
        // See https://codex.wordpress.org/Function_Reference/wp_send_json_sucess
        wp_send_json_success('Post Saved');
    }

    add_action( 'wp_ajax_save_sort', 'dwwwp_save_reorder' ); // first param should be wp_ajax_{followed by action name in ajax request}


}