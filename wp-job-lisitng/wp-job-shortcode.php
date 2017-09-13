<?php
/**
 * @param $atts (for self closing short tags like [job_location_list title="Hello"]
 * @param null $content (for opening and closing tags like [job_location_list]Content goes here [/job_location_list])
 */
function dwwp_job_taxonomy_list($atts, $content = null) {
    // Asssiging default attributes
    // see https://codex.wordpress.org/Function_Reference/shortcode_atts
    $atts = shortcode_atts(
        array(
            'title' => 'Current Job Openings in...',
        ), $atts
    );

    // Get Taxonomy (location)
    // see https://developer.wordpress.org/reference/functions/get_terms/
    $locations = get_terms('location');

    if (!empty($locations) && !is_wp_error($locations)) {
        $displayList  = '<div id="job-location-list">';
        $displayList .= '<h4>' . esc_html__($atts['title']) . '</h4>';
        $displayList .= '<ul>';

        foreach($locations as $location) {
            $displayList .= '<li class="job-location">';
            $displayList .= '<a href="' . esc_url(get_term_link($location)) . '">';
            $displayList .= esc_html__($location->name) . '</a></li>';
        }

        $displayList .= '</ul></div>';

        return $displayList;
    }
}

add_shortcode('job_location_list', 'dwwp_job_taxonomy_list');

function dwwp_jobs_by_location($atts, $content = null) {
    global $post;
    if ( ! isset( $atts['location'] ) ) {
        return '<p class="job-error">You must provide a location for this shortcode to work.</p>';
    }
    // Assigning default attributes
    $atts = shortcode_atts(array(
        'title'      => 'Current Job Openings in',
        'count'      => 1,
        'location'   => '',
        'pagination' => 'off'
    ), $atts );

    // for pagination
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // Custom arguments
    $args = array(
        'post_type' 		=> 'job',
        'post_status'       => 'publish',
        'no_found_rows'     => $atts['pagination'],
        'posts_per_page'    => $atts['count'],
        'paged'			    => $paged,
        'tax_query' 		=> array(
            array(
                'taxonomy' => 'location',
                'field'    => 'slug',
                'terms'    => $atts['location'],
            ),
        )
    );

    $jobs_by_location = new WP_Query($args);

    if ($jobs_by_location-> have_posts()) :
        $location = str_replace('-', ' ', $atts['location']);

        $display_by_location = '<div id="jobs-by-location">';
        $display_by_location .= '<h4>' . esc_html__($atts[ 'title' ]) . '&nbsp' . esc_html__(ucwords($location)) . '</h4>';
        $display_by_location .= '<ul>';

        while ( $jobs_by_location->have_posts() ) : $jobs_by_location->the_post();

            //global $post; // no idea why this is used

            $deadline = get_post_meta(get_the_ID(), 'application_deadline', true);
            $title = get_the_title();
            $slug = get_permalink();

            $display_by_location .= '<li class="job-listing">';
            $display_by_location .= sprintf( '<a href="%s">%s</a>&nbsp&nbsp', esc_url($slug), esc_html__($title));
            $display_by_location .= '<span>' . esc_html($deadline) . '</span>';
            $display_by_location .= '</li>';

        endwhile;

        $display_by_location .= '</ul>';
        $display_by_location .= '</div>';

    else:

        $display_by_location = sprintf(__('<p class="job-error">Sorry, no jobs listed in %s where found.</p>' ), esc_html__(ucwords(str_replace( '-', ' ', $atts[ 'location' ])) ) );

    endif;

    wp_reset_postdata();

    if ($jobs_by_location->max_num_pages > 1  && is_page()) {

        $display_by_location .= '<nav class="prev-next-posts">';
        $display_by_location .= '<div call="nav-pervious">';
        $display_by_location .= get_next_posts_link( __('<span class="meta-nav">&larr;</span> Previous'), $jobs_by_location->max_num_pages);
        $display_by_location .= '</div';
        $display_by_location .= '<div class="next-posts-link">';
        $display_by_location .= get_previous_posts_link(__('<span class="meta-nav">&rarr;</span> Next'));
        $display_by_location .= '</div>';
        $display_by_location .= '</nav>';
    }

    return $display_by_location;
}

add_shortcode('jobs_by_location', 'dwwp_jobs_by_location');