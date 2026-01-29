<?php
$term = get_queried_object();
get_header(); ?>
<main id="primary" class="main-content cyclon_product_category_content">
    <div class="cyclon_tax_wrapper primary">

        <div class="container product-archive__container">


            <!-- Mobile Filter Toggle Button -->
            <button class="filter-toggle-btn" aria-label="Toggle Filters">
                Filters
            </button>

            <!-- Product Filters  -->
            <?php
            // Get current category term
            $current_term = get_queried_object();

            // Get all products in the current category to determine which filter terms are actually used
            $category_products_query = new WP_Query(array(
                'post_type' => 'cyclon_new_product',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cyclon_new_product_cat',
                        'field'    => 'term_id',
                        'terms'    => $current_term->term_id,
                    ),
                ),
            ));
            
            $category_product_ids = $category_products_query->posts;
            wp_reset_postdata();

            $allowed_taxonomies = array(
                'cyclon_range',
                'cyclon_product_grade',
                'cyclon_product_type',
                'cyclon_new_product_acea',
                'cyclon_new_product_oem',
                'cyclon_new_product_cat', // Subcategories as Applications
            );
            $cyclon_taxonomies = array_map('get_taxonomy', $allowed_taxonomies);
            $cyclon_taxonomies = array_filter($cyclon_taxonomies);
            if (! empty($cyclon_taxonomies)): ?>
                <div class="product-filters sticky">
                    <button class="product-filters__close" aria-label="Close Filters">&times;</button>
                    <div lang="el" class="font-ferry black-weight lowercase product-filters__heading"><?php _e('Filters', 'cyclon'); ?></div>
                    <div class="product-filters__grid">
                        <?php
                        $dropdown_wrapper_opened = false;
                        foreach ($cyclon_taxonomies as $taxonomy):
                            // Get ONLY terms that are used by products in the current category
                            $terms = array();
                            
                            // Special handling for cyclon_new_product_cat - show only subcategories
                            if ($taxonomy->name === 'cyclon_new_product_cat') {
                                if ($current_term && isset($current_term->term_id)) {
                                    $terms = get_terms(array(
                                        'taxonomy'   => $taxonomy->name,
                                        'parent'     => $current_term->term_id,
                                        'hide_empty' => true,
                                    ));
                                }
                            } else {
                                // Get terms that are actually used by products in this category
                                if (!empty($category_product_ids)) {
                                    $term_ids = array();
                                    foreach ($category_product_ids as $product_id) {
                                        $product_terms = wp_get_object_terms($product_id, $taxonomy->name, array('fields' => 'ids'));
                                        if (!is_wp_error($product_terms)) {
                                            $term_ids = array_merge($term_ids, $product_terms);
                                        }
                                    }
                                    
                                    // Get unique term IDs and fetch full term objects
                                    $term_ids = array_unique($term_ids);
                                    if (!empty($term_ids)) {
                                        $terms = get_terms(array(
                                            'taxonomy'   => $taxonomy->name,
                                            'include'    => $term_ids,
                                            'hide_empty' => true,
                                        ));
                                    }
                                }
                            }

                            if (is_wp_error($terms) || empty($terms)) {
                                continue;
                            }

                            // Custom ordering for cyclon_range taxonomy
                            if ($taxonomy->name === 'cyclon_range') {
                                $order = array('evo', 'pro', 'eco', 'max');
                                usort($terms, function($a, $b) use ($order) {
                                    $pos_a = array_search(strtolower($a->slug), $order);
                                    $pos_b = array_search(strtolower($b->slug), $order);
                                    
                                    // If both found, sort by position
                                    if ($pos_a !== false && $pos_b !== false) {
                                        return $pos_a - $pos_b;
                                    }
                                    // If only one found, prioritize it
                                    if ($pos_a !== false) return -1;
                                    if ($pos_b !== false) return 1;
                                    // If neither found, maintain original order
                                    return 0;
                                });
                            }
                        ?>
                            <?php
                            $is_dropdown = ($taxonomy->name === 'cyclon_new_product_acea' || $taxonomy->name === 'cyclon_new_product_oem' || $taxonomy->name === 'cyclon_specifications');

                            // Open wrapper before first dropdown
                            if ($is_dropdown && !$dropdown_wrapper_opened) {
                                echo '<div class="product-filters__dropdown-wrapper">
                                <div class="bold text-s uppercase letter-spacing-medium product-filters__approvals-label">Specifications</div>';
                                $dropdown_wrapper_opened = true;
                            }

                            // Close wrapper before non-dropdown elements
                            if (!$is_dropdown && $dropdown_wrapper_opened) {
                                echo '</div>';
                                $dropdown_wrapper_opened = false;
                            }
                            ?>

                            <div class="product-filters__group taxonomy-<?php echo esc_attr($taxonomy->name); ?>">
                                <?php if (!$is_dropdown) { 
                                    // Custom label for subcategories
                                    $filter_label = ($taxonomy->name === 'cyclon_new_product_cat') ? 'Applications' : ($taxonomy->labels->singular_name ?? $taxonomy->label);
                                ?>
                                    <div class="bold text-s uppercase letter-spacing-medium"><?php echo esc_html($filter_label); ?></div>
                                <?php } ?>

                                <?php if ($is_dropdown): 
                                    // Get placeholder text based on taxonomy
                                    $placeholder = 'All';
                                    if ($taxonomy->name === 'cyclon_new_product_acea') {
                                        $placeholder = 'Industry Specs';
                                    } elseif ($taxonomy->name === 'cyclon_new_product_oem') {
                                        $placeholder = 'OEM Specs';
                                    }
                                ?>
                                    <!-- Dropdown for ACEA, OEM, and Specifications -->
                                    <select
                                        name="filters[<?php echo esc_attr($taxonomy->name); ?>][]"
                                        class="product-filters__dropdown text-s">
                                        <option value=""><?php echo esc_html($placeholder); ?></option>
                                        <?php foreach ($terms as $term): ?>
                                            <option value="<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <!-- Checkboxes for other taxonomies -->
                                    <div class="product-filters__options">
                                        <?php foreach ($terms as $term):
                                            $checkbox_id = esc_attr($taxonomy->name . '-' . $term->slug);
                                        ?>
                                            <div class="product-filters__option <?php echo esc_attr($term->slug); ?>">
                                                <input
                                                    type="checkbox"
                                                    name="filters[<?php echo esc_attr($taxonomy->name); ?>][]"
                                                    id="<?php echo $checkbox_id; ?>"
                                                    value="<?php echo esc_attr($term->slug); ?>">
                                                <label for="<?php echo $checkbox_id; ?>" class="text-s">
                                                    <?php echo esc_html($term->name); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <?php 
                                        // Add "All" option for cyclon_range (at the end)
                                        if ($taxonomy->name === 'cyclon_range'):
                                            $all_checkbox_id = esc_attr($taxonomy->name . '-all');
                                        ?>
                                            <div class="product-filters__option all-option">
                                                <input
                                                    type="checkbox"
                                                    name="filters[<?php echo esc_attr($taxonomy->name); ?>][]"
                                                    id="<?php echo $all_checkbox_id; ?>"
                                                    value=""
                                                    checked>
                                                <label for="<?php echo $all_checkbox_id; ?>" class="text-s">
                                                    <?php _e('ALL RANGES', 'cyclon'); ?>
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php
                        // Close wrapper if still open
                        if ($dropdown_wrapper_opened) {
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Products -->
            <?php

            if (have_posts()): ?>
                <div class="container product-grid">
                    
                   
                    <div class="selected-filters" style="display: none;">
                        <div lang="el" class="font-ferry text selected-filters__heading"><?php _e('Selected Filters', 'cyclon'); ?></div>

                        <div class="selected-filters__list-container">
                            <div class="text-xs uppercase selected-filters__list">
                                <!-- Filters will be dynamically inserted here -->
                            </div>
                            <div type="button" class="text-xs uppercase selected-filters__clear-all"><?php _e('Clear All', 'cyclon'); ?></div>
                        </div>
                    </div>

                    <div class="product-count">
                        <?php 
                        global $wp_query;
                        $total_products = $wp_query->found_posts;
                        $product_count_text = $total_products === 1 
                            ? sprintf(__('%d product', 'cyclon'), $total_products)
                            : sprintf(__('%d products', 'cyclon'), $total_products);
                        ?>
                        <span class="text-s uppercase product-count__number"><?php echo esc_html($product_count_text); ?></span>
                    </div>

                    <div class="archive-grid relative">
                        <div class="archive-grid__loader hidden">
                        </div>

                        <?php while (have_posts()): the_post(); ?>

                            <?php include 'template-parts/components/product-card.php'; ?>

                        <?php endwhile; ?>
                    </div>

                    <div class="archive-grid__bottom pagination">
                        <?php
                        echo paginate_links(array(
                            'total'   => $wp_query->max_num_pages,
                            'current' => max(1, get_query_var('paged')),
                            'type'    => 'list',
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php
get_footer();
