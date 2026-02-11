<?php
get_header();

if (have_posts()): while (have_posts()): the_post();
?>
        <main id="primary" class="main-content cyclon_single_product_new">
            <div class="cyclon_product__Inner">
                <div class="container">
                    <!-- Product Category -->
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'cyclon_new_product_cat');
                    $category = null;
                    $category_link = '';
                    if ($categories && !is_wp_error($categories)):
                        $category = reset($categories); // Get the first category
                        $category_link = get_term_link($category);
                    endif;
                    ?>
                    <?php if ($category && $category_link): ?>
                        <a href="<?php echo esc_url($category_link); ?>" class="single-product-new__category-info">
                        <?php else: ?>
                            <div class="single-product-new__category-info">
                            <?php endif; ?>
                            <?php if ($category): ?>
                                <div class="text-s primary single-product-new__category-name">
                                    <span class="bold"><?php echo esc_html($category->name); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($category): ?>
                                <div class="single-product-new__category-image">
                                    <?php
                                    // Determine which category to use for the image
                                    $image_category = $category;
                                    if ($category->parent != 0) {
                                        // If this is a child category, get the parent category for the image
                                        $parent_category = get_term($category->parent, 'cyclon_new_product_cat');
                                        if ($parent_category && !is_wp_error($parent_category)) {
                                            $image_category = $parent_category;
                                        }
                                    }

                                    $category_image = get_field('new_product_category_image_single', $image_category);
                                    if ($category_image): ?>
                                        <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($category && $category_link): ?>
                        </a>
                    <?php else: ?>
                </div>
            <?php endif; ?>
            <div class="single-product-new__grid">
                <?php
                // Categories that should have background image
                $bg_image_categories = array('passenger-light-duty', 'moto', 'agriculture', 'gardening', 'leisure');
                $product_terms = wp_get_post_terms(get_the_ID(), 'cyclon_new_product_cat');
                $has_bg_image = false;

                if (!empty($product_terms) && !is_wp_error($product_terms)) {
                    foreach ($product_terms as $term) {
                        if (in_array($term->slug, $bg_image_categories)) {
                            $has_bg_image = true;
                            break;
                        }
                    }
                }

                // Also show bg image if product has a cyclon_range value
                if (!$has_bg_image) {
                    $range_terms = wp_get_post_terms(get_the_ID(), 'cyclon_range');
                    if (!empty($range_terms) && !is_wp_error($range_terms)) {
                        $has_bg_image = true;
                    }
                }

                // $bg_style = $has_bg_image ? ' style="background-image: url(/wp-content/uploads/2026/01/product-bg-img.svg);"' : '';
                $bg_style = $has_bg_image ? ' /wp-content/uploads/2026/01/product-bg-img.svg)' : '';
                ?>

                <!-- Image  -->
                <div class="single-product-new__img-container relative">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                    <?php else: ?>
                        <img src="/wp-content/uploads/2026/01/vareli_new.png"
                            class="img-fluid" alt="<?php the_title(); ?>" />
                    <?php endif; ?>



                    <?php if ($has_bg_image == true): ?>
                        <div class="single-product-new__img-bg-img absolute">
                            <img src="<?php echo $bg_style; ?>" alt="">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Info  -->
                <div class="primary single-product-new__info">


                    <div class="primary">
                        <h1 class="text-2xl primary single-product-new__title">
                            <span>Cyclon </span>
                            <br>
                            <?php
                            $product_range = wp_get_post_terms(get_the_ID(), 'cyclon_range');
                            if (!empty($product_range) && !is_wp_error($product_range)):
                            ?>
                                <span><?php echo $product_range[0]->name; ?> </span>
                            <?php endif; ?>
                            <span><?php the_title(); ?></span>
                        </h1>


                        <?php
                        $grade_terms = get_the_terms(get_the_ID(), 'cyclon_product_grade');
                        if (!empty($grade_terms) && !is_wp_error($grade_terms)) {
                            // Get color from cyclon_range taxonomy term
                            $range_terms = get_the_terms(get_the_ID(), 'cyclon_range');
                            $color_style = '';
                            if (!empty($range_terms) && !is_wp_error($range_terms)) {
                                $color = get_field('color', $range_terms[0]);
                                if ($color) {
                                    $color_style = ' style="color: ' . esc_attr($color) . ';"';
                                }
                            }
                        ?>
                            <div class="text-xl single-product-new__range-code" <?php echo $color_style; ?>>
                                <?php echo esc_html($grade_terms[0]->name); ?>
                            </div>
                        <?php } ?>

                        <div>
                            <div class="single-product-new__previous-info-container">

                                <div class="text">
                                    <?php if (get_field('single_product__parent_code')): ?>
                                        <div class="text-sm">
                                            <span>Parent Code:</span>
                                            <span><?php echo get_field('single_product__parent_code'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <?php if (get_field('single_product__previous_name')): ?>

                                    <a href="<?php echo get_field('single_product__replaced_product'); ?>" class="white single-product-new__previous-info uppercase">
                                        <span class="text-s"><?php echo __('Replaces', 'cyclon'); ?></span>
                                        <div class="text accent">
                                            <span><?php echo get_field('single_product__previous_name'); ?></span>
                                            <span><?php echo get_field('single_product__previous_code'); ?></span>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Additional fields  -->
                            <div class="text-ms single-product-new__bullets">
                                <?php if (get_field('single_product_new__banner_1')): ?>
                                    <li>
                                        <span><?php echo get_field('single_product_new__banner_1'); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if (get_field('single_product_new__banner_2')): ?>
                                    <li>
                                        <span><?php echo get_field('single_product_new__banner_2'); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $product_types = wp_get_post_terms(get_the_ID(), 'cyclon_product_type');
                                if (!empty($product_types) && !is_wp_error($product_types)):
                                    $type_names = array();
                                    foreach ($product_types as $type) {
                                        $type_names[] = $type->name;
                                    }
                                ?>
                                    <li>
                                        <span><?php echo implode(', ', $type_names); ?></span>
                                    </li>
                                <?php endif; ?>


                            </div>

                        </div>
                    </div>





                    <div>
                        <div class="text-ms single-product-new__content">
                            <?php the_content(); ?>
                        </div>

                        <div class="single-product-new__toggle">
                            <div class="show-more-line"></div>
                            <div>
                                <div class="text-ms text-center single-product-new__toggle-content" aria-expanded="false">
                                    Show more
                                </div>
                            </div>
                            <div class="show-more-line"></div>
                        </div>

                    </div>

                    <?php
                    $specifications = get_the_terms(get_the_ID(), 'cyclon_specifications');
                    if ($specifications && !is_wp_error($specifications)):
                    ?>
                        <div>
                            <div>
                                <div class="text-s bold">Specifications</div>
                                <div class="text-ms">
                                    <?php
                                    $spec_names = array();
                                    foreach ($specifications as $spec) {
                                        $spec_names[] = esc_html($spec->name);
                                    }
                                    echo implode(', ', $spec_names);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div>
                        <?php if (get_field('single_product__packaging')): ?>
                            <div>
                                <div class="text-s bold">Packaging</div>
                                <div class="text-ms"><?php echo get_field('single_product__packaging'); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-buttons__container">
                        <!-- PDFs  -->
                        <?php if (have_rows('technical_guides')): ?>
                            <div class="product-buttons single-product-new__technical-guides">
                                <?php while (have_rows('technical_guides')): the_row(); ?>
                                    <a href="<?php echo get_sub_field('guide_pdf'); ?>" class="product-pill" target="_blank">
                                        <span class="product-pill__title">
                                            <?php echo get_sub_field('guide_name'); ?>
                                        </span>
                                        <span class="product-pill__subtitle">
                                            <?php echo get_sub_field('guide_type'); ?>
                                        </span>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        <div class="product-buttons">
                            <a href="/" class="product-pill product-pill--primary" target="_blank">
                                <span class="product-pill__title">
                                    <?php _e('Product Catalogue', 'cyclon'); ?>
                                </span>
                                <span class="product-pill__subtitle">
                                    <?php _e('Download here', 'cyclon'); ?>
                                </span>
                            </a>
                        </div>
                        <div class="product-buttons">
                            <a href="/" class="product-pill" target="_blank">
                                <span class="product-pill__title">
                                    <?php _e('Product Matching Catalogue', 'cyclon'); ?>
                                </span>
                                <span class="product-pill__subtitle">
                                    <?php _e('Download here', 'cyclon'); ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        </main>

        <?php
        // Build related products query with priority:
        // 1. Products from same cyclon_product_range taxonomy (up to 3)
        // 2. Products from same category/subcategory to fill remaining slots (up to 3 total)

        $current_post_id = get_the_ID();
        $related_products = array();
        $excluded_ids = array($current_post_id);

        // Step 1: Get products from same range taxonomy (priority)
        $range_terms = wp_get_post_terms($current_post_id, 'cyclon_product_range');

        if (!empty($range_terms) && !is_wp_error($range_terms)) {
            $range_term_ids = wp_list_pluck($range_terms, 'term_id');

            $rangeArgs = array(
                'post_type' => 'cyclon_new_product',
                'posts_per_page' => 3,
                'post__not_in' => $excluded_ids,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cyclon_product_range',
                        'field' => 'term_id',
                        'terms' => $range_term_ids,
                    ),
                ),
            );

            $rangeQuery = new WP_Query($rangeArgs);

            if ($rangeQuery->have_posts()) {
                while ($rangeQuery->have_posts()) {
                    $rangeQuery->the_post();
                    $related_products[] = get_post();
                    $excluded_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }
        }

        // Step 2: Fill remaining slots with products from same category (up to 3 total)
        $remaining_slots = 3 - count($related_products);

        if ($remaining_slots > 0) {
            $category_terms = wp_get_post_terms($current_post_id, 'cyclon_new_product_cat');

            if (!empty($category_terms) && !is_wp_error($category_terms)) {
                // Filter to get only child categories (those with a parent)
                $child_categories = array_filter($category_terms, function ($term) {
                    return $term->parent > 0;
                });

                // Use child categories if they exist, otherwise use all categories
                $terms_to_use = !empty($child_categories) ? $child_categories : $category_terms;
                $term_ids = wp_list_pluck($terms_to_use, 'term_id');

                $categoryArgs = array(
                    'post_type' => 'cyclon_new_product',
                    'posts_per_page' => $remaining_slots,
                    'post__not_in' => $excluded_ids,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'cyclon_new_product_cat',
                            'field' => 'term_id',
                            'terms' => $term_ids,
                        ),
                    ),
                );

                $categoryQuery = new WP_Query($categoryArgs);

                if ($categoryQuery->have_posts()) {
                    while ($categoryQuery->have_posts()) {
                        $categoryQuery->the_post();
                        $related_products[] = get_post();
                    }
                    wp_reset_postdata();
                }
            }
        }

        // Create a custom query object with our combined results
        $relatedQuery = new WP_Query();
        $relatedQuery->posts = $related_products;
        $relatedQuery->post_count = count($related_products);
        $relatedQuery->found_posts = count($related_products);
        $relatedQuery->max_num_pages = 1;

        // Only render section if there are related products
        if ($relatedQuery->have_posts()): ?>
            <div class="cyclon_single__relatedWrapper">
                <h3 class="relatedTitle text-center"><?php echo _e('Similar Products', 'cyclon'); ?></h3>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="relatedProducts__SuperWrapper">
                                <div class="relatedProducts__Wrapper swiper">
                                    <div class="relatedProducts__Inner swiper-wrapper">
                                        <?php while ($relatedQuery->have_posts()): $relatedQuery->the_post(); ?>
                                            <div class="swiper-slide">
                                                <?php include 'template-parts/components/product-card.php';
                                                ?>
                                            </div>
                                        <?php endwhile;
                                        wp_reset_postdata(); ?>

                                    </div>

                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

<?php endwhile;
endif; ?>


<?php
get_footer();
