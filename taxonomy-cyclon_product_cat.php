<?php
$term = get_queried_object();
get_header(); ?>
<main id="primary" class="main-content cyclon_product_category_content">
    <div class="cyclon_tax_wrapper">

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
            );
            $cyclon_taxonomies = array_map('get_taxonomy', $allowed_taxonomies);
            $cyclon_taxonomies = array_filter($cyclon_taxonomies);
            if (! empty($cyclon_taxonomies)): ?>
                <div class="product-filters">
                    <h3><?php _e('Φίλτρα:', 'cyclon'); ?></h3>
                    <div class="product-filters__grid">
                        <?php foreach ($cyclon_taxonomies as $taxonomy):
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
                            <div class="product-filters__group taxonomy-<?php echo esc_attr($taxonomy->name); ?>">
                                <h4><?php echo esc_html($taxonomy->labels->singular_name ?? $taxonomy->label); ?></h4>
                                <div class="product-filters__options">
                                    <?php foreach ($terms as $term):
                                        $checkbox_id = esc_attr($taxonomy->name . '-' . $term->slug);
                                    ?>
                                        <div class="product-filters__option">
                                            <input
                                                type="checkbox"
                                                name="filters[<?php echo esc_attr($taxonomy->name); ?>][]"
                                                id="<?php echo $checkbox_id; ?>"
                                                value="<?php echo esc_attr($term->slug); ?>">
                                            <label for="<?php echo $checkbox_id; ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Products -->
            <?php

            if (have_posts()): ?>
                <div class="container product-grid">
                    <div>
                        <h4><?php _e('Επιλεγμένα Φίλτρα:', 'cyclon'); ?></h4>
                        <div>
                            <div>
                                <span>Vehicle Type</span>
                                <span>10W - 40</span>
                            </div>
                            <button><?php _e('Διαγραφή όλων', 'cyclon'); ?></button>
                        </div>
                    </div>

                    <div class="archive-grid relative row g-2">
                        <div class="archive-grid__loader hidden">
                        </div>

                        <?php while (have_posts()): the_post(); ?>


                            <?php include 'template-parts/components/product-card.php'; ?>

                        <?php endwhile; ?>
                    </div>

                    <div class="archive-grid__bottom">
                        <button type="button" class="archive-grid__load-more">Load More Products <div class="ic-arrow"></div>
                        </button>
                        <div class="archive-grid__no-more-posts">No more products</div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php
get_footer();
