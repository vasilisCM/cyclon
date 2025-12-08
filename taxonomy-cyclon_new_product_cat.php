<?php
$term = get_queried_object();
get_header(); ?>
<main id="primary" class="main-content cyclon_product_category_content">
    <div class="cyclon_tax_wrapper primary">

        <div class="container product-archive__container">


            <!-- Product Filters  -->
            <?php
            // Get post IDs from current archive query
            global $wp_query;
            $post_ids = array();
            if (! empty($wp_query->posts)) {
                $post_ids = wp_list_pluck($wp_query->posts, 'ID');
            }

            $allowed_taxonomies = array(
                'cyclon_range',
                'cyclon_product_grade',
                'cyclon_product_type',
                'cyclon_new_product_acea',
                'cyclon_new_product_oem',
            );
            $cyclon_taxonomies = array_map('get_taxonomy', $allowed_taxonomies);
            $cyclon_taxonomies = array_filter($cyclon_taxonomies);
            if (! empty($cyclon_taxonomies)): ?>
                <div class="product-filters sticky">
                    <div lang="el" class="font-ferry black-weight lowercase product-filters__heading"><?php _e('Φιλτρα', 'cyclon'); ?></div>
                    <div class="product-filters__grid">
                        <?php
                        $dropdown_wrapper_opened = false;
                        foreach ($cyclon_taxonomies as $taxonomy):
                            // Get terms only for products in current archive
                            $terms = array();
                            if (! empty($post_ids)) {
                                $term_ids = array();
                                foreach ($post_ids as $post_id) {
                                    $post_terms = wp_get_object_terms($post_id, $taxonomy->name, array('fields' => 'ids'));
                                    if (! is_wp_error($post_terms)) {
                                        $term_ids = array_merge($term_ids, $post_terms);
                                    }
                                }
                                // Get unique term IDs and fetch full term objects
                                $term_ids = array_unique($term_ids);
                                if (! empty($term_ids)) {
                                    $terms = get_terms(array(
                                        'taxonomy'   => $taxonomy->name,
                                        'include'    => $term_ids,
                                        'hide_empty' => false,
                                    ));
                                }
                            }

                            if (is_wp_error($terms) || empty($terms)) {
                                continue;
                            }
                        ?>
                            <?php
                            $is_dropdown = ($taxonomy->name === 'cyclon_new_product_acea' || $taxonomy->name === 'cyclon_new_product_oem');

                            // Open wrapper before first dropdown
                            if ($is_dropdown && !$dropdown_wrapper_opened) {
                                echo '<div class="product-filters__dropdown-wrapper">
                                <div class="bold text-s uppercase letter-spacing-medium product-filters__approvals-label">Approvals</div>';
                                $dropdown_wrapper_opened = true;
                            }

                            // Close wrapper before non-dropdown elements
                            if (!$is_dropdown && $dropdown_wrapper_opened) {
                                echo '</div>';
                                $dropdown_wrapper_opened = false;
                            }
                            ?>

                            <div class="product-filters__group taxonomy-<?php echo esc_attr($taxonomy->name); ?>">
                                <?php if (!$is_dropdown) { ?>
                                    <div class="bold text-s uppercase letter-spacing-medium"><?php echo esc_html($taxonomy->labels->singular_name ?? $taxonomy->label); ?></div>
                                <?php } ?>

                                <?php if ($is_dropdown): ?>
                                    <!-- Dropdown for ACEA and OEM -->
                                    <select
                                        name="filters[<?php echo esc_attr($taxonomy->name); ?>][]"
                                        class="product-filters__dropdown text-s">
                                        <option value="" disabled selected><?php echo esc_html($taxonomy->labels->singular_name ?? $taxonomy->label); ?></option>
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
                        <div lang="el" class="font-ferry text selected-filters__heading"><?php _e('Επιλεγμενα Φιλτρα', 'cyclon'); ?></div>

                        <div class="selected-filters__list-container">
                            <div class="text-xs uppercase selected-filters__list">
                                <!-- Filters will be dynamically inserted here -->
                            </div>
                            <div type="button" class="text-xs uppercase selected-filters__clear-all"><?php _e('Διαγραφη ολων', 'cyclon'); ?></div>
                        </div>
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
