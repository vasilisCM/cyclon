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

    $posts_per_page = isset($_POST['postsNumber']) ? intval($_POST['postsNumber']) : 8;
    $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
    $post_type = isset($_POST['postType']) ? sanitize_text_field($_POST['postType']) : 'cyclon_product';

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1, // Get ALL to sort globally, paginate after
        'tax_query' => array('relation' => 'AND'),
        'meta_query' => array(),
    );

    // Handle current archive context (maintain the current archive constraint)
    $has_archive_context = false;
    if (!empty($_POST['current_archive_context'])) {
        $context = json_decode(stripslashes($_POST['current_archive_context']), true);
        if (!empty($context['taxonomy']) && !empty($context['term'])) {
            $args['tax_query'][] = array(
                'taxonomy' => $context['taxonomy'],
                'field' => 'term_id',
                'terms' => intval($context['term']),
            );
            $has_archive_context = true;
        }
    }

    // Handle archive context from customTaxonomy and termSlugs (fallback if current_archive_context not set)
    $archive_taxonomy = null;
    $term_slug = null;

    if (!$has_archive_context && !empty($_POST['customTaxonomy']) && !empty($_POST['termSlugs'])) {
        $archive_taxonomy = sanitize_text_field($_POST['customTaxonomy']);
        $term_slug = sanitize_text_field($_POST['termSlugs']);

        $args['tax_query'][] = array(
            'taxonomy' => $archive_taxonomy,
            'field' => 'slug',
            'terms' => $term_slug,
        );

        $debug_info['applied_filters']['archive_taxonomy'] = $archive_taxonomy;
        $debug_info['applied_filters']['archive_term'] = $term_slug;
    }

    // Define our custom taxonomies
    $custom_taxonomies = array(
        'cyclon_range',
        'cyclon_product_grade',
        'cyclon_product_type',
        'cyclon_new_product_acea',
        'cyclon_new_product_oem',
        'cyclon_specifications',
        'cyclon_new_product_cat', // Subcategories as Applications
    );

    // Handle filters from checkbox structure: filters[cyclon_range][], filters[cyclon_product_grade][], filters[cyclon_product_type][]
    if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
        foreach ($_POST['filters'] as $taxonomy => $term_slugs) {
            if (in_array($taxonomy, $custom_taxonomies, true) && !empty($term_slugs)) {
                // Ensure term_slugs is an array
                if (!is_array($term_slugs)) {
                    $term_slugs = array($term_slugs);
                }

                // Filter out empty values (for "All" options like "All Ranges")
                $term_slugs = array_filter($term_slugs, function($slug) {
                    return !empty($slug);
                });

                // Only add tax query if there are actual term slugs after filtering
                if (!empty($term_slugs)) {
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
    }

    // Add final query args to debug info
    $debug_info['final_query_args'] = $args;

    // Query Custom Products
    $query = new WP_Query($args);
    $products = array();
    $available_filters = array(); // Store available taxonomy term values

    // Sort ALL products globally by cyclon_range, then manually paginate
    $all_products_sorted = array();
    $total_found = 0;
    
    if ($query->have_posts()) {
        $all_posts = $query->posts;
        $range_order = array('evo', 'pro', 'eco', 'max');
        
        // Sort ALL posts by range (globally, not per-page)
        usort($all_posts, function($a, $b) use ($range_order) {
            $terms_a = wp_get_object_terms($a->ID, 'cyclon_range', array('fields' => 'slugs'));
            $terms_b = wp_get_object_terms($b->ID, 'cyclon_range', array('fields' => 'slugs'));
            
            $has_range_a = !is_wp_error($terms_a) && !empty($terms_a);
            $has_range_b = !is_wp_error($terms_b) && !empty($terms_b);
            
            if ($has_range_a && $has_range_b) {
                $slug_a = strtolower($terms_a[0]);
                $slug_b = strtolower($terms_b[0]);
                
                $pos_a = array_search($slug_a, $range_order);
                $pos_b = array_search($slug_b, $range_order);
                
                if ($pos_a !== false && $pos_b !== false) {
                    return $pos_a - $pos_b;
                }
                if ($pos_a !== false) return -1;
                if ($pos_b !== false) return 1;
            }
            
            if ($has_range_a && !$has_range_b) return -1;
            if (!$has_range_a && $has_range_b) return 1;
            
            return 0;
        });
        
        // Store total count
        $total_found = count($all_posts);
        
        // Paginate after sorting
        $offset = ($page - 1) * $posts_per_page;
        $posts_for_page = array_slice($all_posts, $offset, $posts_per_page);
        
        // Update query with paginated sorted posts
        $query->posts = $posts_for_page;
        $query->post_count = count($posts_for_page);
        $query->found_posts = $total_found;
        $query->max_num_pages = ceil($total_found / $posts_per_page);
        $query->rewind_posts();
    }

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Get truncated content (20 words like in PHP template)
            $content = strip_tags(get_the_content());
            $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
            $short_content = implode(' ', array_slice($words, 0, 20));
            if (count($words) > 20) {
                $short_content .= '...';
            }
            
            // Get range taxonomy for display and color
            $range_display = '';
            $range_color = '';
            $range_terms = get_the_terms($post_id, 'cyclon_range');
            if (!empty($range_terms) && !is_wp_error($range_terms)) {
                $term_names = wp_list_pluck($range_terms, 'name');
                $range_display = implode(', ', $term_names);
                
                // Get color from first range term
                $color = get_field('color', $range_terms[0]);
                if ($color) {
                    $range_color = $color;
                }
            }
            
            // Get product grade with color from range taxonomy
            $grade_data = null;
            $grade_terms = get_the_terms($post_id, 'cyclon_product_grade');
            if (!empty($grade_terms) && !is_wp_error($grade_terms)) {
                $grade_data = array(
                    'name' => $grade_terms[0]->name,
                    'color' => $range_color,
                );
            }
            
            // Build product data
            $products[] = array(
                'id' => $post_id,
                'title' => get_the_title(),
                'image' => get_the_post_thumbnail_url($post_id, 'full'),
                'permalink' => get_permalink(),
                'content_excerpt' => $short_content,
                'grade' => $grade_data,
                'range_display' => $range_display,
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

                // Check if this is the archive taxonomy from current_archive_context
                if (!empty($_POST['current_archive_context'])) {
                    $context = json_decode(stripslashes($_POST['current_archive_context']), true);
                    if (!empty($context['taxonomy']) && $context['taxonomy'] === $taxonomy) {
                        $skip_taxonomy = true;
                    }
                }

                // Check if this is the archive taxonomy from customTaxonomy
                if (!$skip_taxonomy && !empty($_POST['customTaxonomy']) && $_POST['customTaxonomy'] === $taxonomy) {
                    $skip_taxonomy = true;
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

    $pagination_html = '';
    if ($query->max_num_pages > 1) {
        $base_link = '';
        if ($archive_taxonomy && $term_slug) {
            $term = get_term_by('slug', $term_slug, $archive_taxonomy);
            if ($term && !is_wp_error($term)) {
                $base_link = get_term_link($term);
            }
        }

        if (!$base_link) {
            $base_link = get_pagenum_link(1);
        }

        if (!is_wp_error($base_link)) {
            $pagination_html = paginate_links(array(
                'base' => trailingslashit($base_link) . '%_%',
                'format' => 'page/%#%/',
                'current' => $page,
                'total' => $query->max_num_pages,
                'type' => 'list',
            ));
        }
    }

    // Send JSON Response
    wp_send_json(array(
        'success' => true,
        'products' => $products,
        'total_products' => $query->found_posts, // Total number of products matching the filter
        'available_filters' => $available_filters,
        'pagination_html' => $pagination_html,
        'current_page' => $page,
        'total_pages' => $query->max_num_pages,
        'debug_info' => $debug_info,
    ));
}
