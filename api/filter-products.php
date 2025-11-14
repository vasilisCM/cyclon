<?php
// AJAX API
add_action('wp_ajax_filter_products', 'custom_filter_products');
add_action('wp_ajax_nopriv_filter_products', 'custom_filter_products');

function custom_filter_products()
{
    // Debug: Collect received data for response
    $debug_info = array(
        'received_post_data' => $_POST,
        'applied_filters' => array()
    );

    $args = array(
        'post_type' => 'cyclon_product',
        'posts_per_page' => isset($_POST['postsNumber']) ? intval($_POST['postsNumber']) : -1,
        'tax_query' => array('relation' => 'AND'),
        'meta_query' => array(),
    );

    // Handle current archive context (maintain the current archive constraint)
    if (!empty($_POST['current_archive_context'])) {
        $context = json_decode(stripslashes($_POST['current_archive_context']), true);
        if (!empty($context['taxonomy']) && !empty($context['term'])) {
            $args['tax_query'][] = array(
                'taxonomy' => $context['taxonomy'],
                'field' => 'term_id',
                'terms' => intval($context['term']),
            );
        }
    }

    // Define our custom taxonomies
    $custom_taxonomies = array(
        'cyclon_range',
        'cyclon_product_grade',
        'cyclon_product_type',
    );

    // Handle filters from checkbox structure: filters[cyclon_range][], filters[cyclon_product_grade][], filters[cyclon_product_type][]
    if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
        foreach ($_POST['filters'] as $taxonomy => $term_slugs) {
            if (in_array($taxonomy, $custom_taxonomies, true) && !empty($term_slugs)) {
                // Ensure term_slugs is an array
                if (!is_array($term_slugs)) {
                    $term_slugs = array($term_slugs);
                }

                $debug_info['applied_filters'][$taxonomy] = $term_slugs;

                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', $term_slugs),
                    'operator' => 'IN',
                );
            }
        }
    }

    // Add final query args to debug info
    $debug_info['final_query_args'] = $args;

    // Query Custom Products
    $query = new WP_Query($args);
    $products = array();
    $available_filters = array(); // Store available taxonomy term values

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Build product data
            $products[] = array(
                'id' => $post_id,
                'title' => get_the_title(),
                'image' => get_the_post_thumbnail_url($post_id, 'full'),
                'permalink' => get_permalink(),
            );

            // Add ACF field values to the last product in the array
            $custom_fields = get_post_meta($post_id);
            $formatted_custom_fields = array();

            foreach ($custom_fields as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $field_value = maybe_unserialize($value[0]);

                    // Repeater field
                    if (function_exists('have_rows') && have_rows($key, $post_id)) {
                        $repeater_data = array();
                        while (have_rows($key, $post_id)) {
                            the_row();
                            $sub_fields = get_row(true);
                            $sub_field_data = array();

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
                        $formatted_custom_fields[$key] = wp_get_attachment_url($field_value);
                    } else {
                        $formatted_custom_fields[$key] = $field_value;
                    }
                }
            }

            // Append ACF to the last added product
            $products[count($products) - 1]['custom_fields'] = $formatted_custom_fields;

            // Collect available taxonomy terms from filtered products
            foreach ($custom_taxonomies as $taxonomy) {
                // Skip the current archive taxonomy (don't show it in filters)
                $skip_taxonomy = false;
                if (!empty($_POST['current_archive_context'])) {
                    $context = json_decode(stripslashes($_POST['current_archive_context']), true);
                    if (!empty($context['taxonomy']) && $context['taxonomy'] === $taxonomy) {
                        $skip_taxonomy = true;
                    }
                }

                if (!$skip_taxonomy) {
                    $terms = wp_get_post_terms($post_id, $taxonomy);

                    if (!is_wp_error($terms) && !empty($terms)) {
                        foreach ($terms as $term) {
                            if (!isset($available_filters[$taxonomy])) {
                                $available_filters[$taxonomy] = array();
                            }
                            $available_filters[$taxonomy][$term->slug] = $term->name;
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    // Ensure unique filter values
    foreach ($available_filters as $key => $values) {
        $available_filters[$key] = array_unique($values);
    }

    // Send JSON Response
    wp_send_json(array(
        'success' => true,
        'products' => $products,
        'total_products' => $query->found_posts, // Total number of products matching the filter
        'available_filters' => $available_filters,
        'debug_info' => $debug_info,
    ));
}
