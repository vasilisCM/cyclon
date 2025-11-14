<?php
add_action('wp_ajax_load_more_posts', 'load_more_posts_handler');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_handler');

function load_more_posts_handler()
{
    // Get the form data
    $postType = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'post';
    $customTaxonomy = isset($_POST['customTaxonomy']) ? sanitize_text_field($_POST['customTaxonomy']) : null;
    $termSlugs = isset($_POST['termSlugs']) ? sanitize_text_field($_POST['termSlugs']) : null;
    $searchTerm = isset($_POST['searchTerm']) && $_POST['searchTerm'] !== "null" ? sanitize_text_field($_POST['searchTerm']) : '';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $postsNumber = isset($_POST['postsNumber']) ? intval($_POST['postsNumber']) : -1;


    $args = [
        'post_type' => $postType,
        'posts_per_page' => $postsNumber,
        'offset' => $offset,
    ];

    if ($searchTerm !== '') {
        $args['s'] = $searchTerm;
    }

    if ($customTaxonomy && $termSlugs) {
        $args['tax_query'] = [
            [
                'taxonomy' => $customTaxonomy,
                'field' => 'slug',
                'terms' => explode(',', $termSlugs),
            ]
        ];
    }

    // Log the query arguments for debugging
    error_log('Query Args: ' . print_r($args, true));

    $query = new WP_Query($args);

    // Log the SQL query for debugging
    error_log('WP_Query SQL: ' . $query->request);

    if ($query->have_posts()) {
        $posts = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $custom_fields = get_post_meta($post_id);

            // Format custom fields
            $formatted_custom_fields = [];
            foreach ($custom_fields as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $field_value = maybe_unserialize($value[0]);

                    // Check if the field is a repeater
                    if (have_rows($key, $post_id)) {
                        $repeater_data = [];
                        while (have_rows($key, $post_id)) {
                            the_row();
                            $sub_fields = get_sub_field();
                            $sub_field_data = [];
                            foreach ($sub_fields as $sub_key => $sub_value) {
                                if (is_numeric($sub_value) && wp_attachment_is_image($sub_value)) {
                                    $sub_value = wp_get_attachment_url($sub_value);
                                }
                                $sub_field_data[$sub_key] = $sub_value;
                            }
                            $repeater_data[] = $sub_field_data;
                        }
                        $formatted_custom_fields[$key] = $repeater_data;
                    } elseif (is_numeric($field_value) && wp_attachment_is_image($field_value)) {
                        $field_value = wp_get_attachment_url($field_value);
                        $formatted_custom_fields[$key] = $field_value;
                    } else {
                        $formatted_custom_fields[$key] = $field_value;
                    }
                }
            }

            $post_data = [
                'title' => get_the_title(),
                'content' => get_the_content(),
                'excerpt' => get_the_excerpt(),
                'featured_image' => get_the_post_thumbnail_url($post_id, 'full'),
                'featured_image_caption' => (get_post(get_post_thumbnail_id($post_id)))->post_excerpt ?? '',
                'permalink' => get_permalink(),
                'custom_fields' => $formatted_custom_fields,
            ];

            $posts[] = $post_data;
        }
        wp_reset_postdata();

        wp_send_json_success([
            'data' => [
                'postsInfo' => $posts,
                'totalPosts' => $query->found_posts,
            ]
        ]);
    } else {
        // Log an error message if no posts are found
        error_log('No posts found for query: ' . print_r($args, true));

        wp_send_json_success([
            'data' => [
                'postsInfo' => [],
                'totalPosts' => 0,
            ]
        ]);
    }
}