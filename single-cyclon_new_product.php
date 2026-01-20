<?php
get_header();

if (have_posts()): while (have_posts()): the_post();
?>
        <main id="primary" class="main-content cyclon_single_product_new">
            <div class="cyclon_product__Inner">
                <div class="container">
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

                        $bg_style = $has_bg_image ? ' style="background-image: url(/wp-content/uploads/2026/01/product-bg-img.svg);"' : '';
                        ?>

                        <!-- Image  -->
                        <div class="single-product-new__img-container" <?php echo $bg_style; ?>>
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>

                        <!-- Info  -->
                        <div class="primary single-product-new__info">
<div class="single-product-new__category-info">
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'cyclon_new_product_cat');
                            if ($categories && !is_wp_error($categories)):
                                $category = reset($categories); // Get the first category
                            ?>
                                <div class="text-s primary single-product-new__category-name">
                                    <span class="bold"><?php echo esc_html($category->name); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($category): ?>
                                <div class="single-product-new__category-image">
                                  <?php 
                                  $category_image = get_field('new_product_category_image_single', $category);
                                  if ($category_image): ?>
                                      <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                  <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            </div>

                            <div class="primary">
                                <h1 class="text-2xl primary single-product-new__title">
                                    <span>Cyclon </span>
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

                                <div class="text">
                                    <?php if (get_field('single_product__parent_code')): ?>
                                        <div class="text-sm">
                                            <span>Parent Code:</span>
                                            <span><?php echo get_field('single_product__parent_code'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="single-product-new__previous-info uppercase">
                                <?php if (get_field('single_product__previous_name')): ?>
                                 
                                        <span class="text-s">Replaces</span>
                                        <div class="text accent">
                                            <span><?php echo get_field('single_product__previous_name'); ?></span>
                                            <span><?php echo get_field('single_product__previous_code'); ?></span> 
                                        </div>
                                        
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

                            <div>
                                <div class="text-sm single-product-new__content">
                                    <?php the_content(); ?>
                                </div>
                                <div class="text-sm bold single-product-new__toggle-content" aria-expanded="false">
                                    Show more...
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
        </main>

        <?php
        // Build related products query
        $rel = get_field('related_glue');
        $relatedArgs = array();
        
        if (!empty($rel['select_glue'])):
            $postTermsObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_cat');

            $cyclonTypes = array();
            $cyclonGrades = array();
            $cyclonSoaps = array();
            $cyclonNlgi = array();

            $relatedArgs = array(
                'post_type' => 'cyclon_product',
                'posts_per_page' => 10,
                'post__not_in' => [get_the_ID()]
            );
            foreach ($rel['select_glue'] as $r) {
                if ($r == 'type') {
                    $postTypesObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_type');

                    foreach ($postTypesObj as $pg) {
                        $cyclonTypes[] = $pg->term_id;
                    }
                    if (!empty($postTypesObj)):
                        $postTerms = $postTypesObj[0]->term_id;

                        $relatedArgs['tax_query'][] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'cyclon_product_type',
                                'field' => 'term_id',
                                'terms' => $cyclonTypes
                            ),
                            array(
                                'taxonomy' => 'cyclon_product_cat',
                                'field' => 'term_id',
                                'terms' => $postTermsObj[0]->term_id
                            )
                        );
                    endif;
                }
                if ($r == 'grade') {
                    $postGradesObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_grade');
                    foreach ($postGradesObj as $pg) {
                        $cyclonGrades[] = $pg->term_id;
                    }
                    if (!empty($postGradesObj)):

                        $postGrades = $postGradesObj[0]->term_id;
                        $relatedArgs['tax_query'][] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'cyclon_product_grade',
                                'field' => 'term_id',
                                'terms' => $cyclonGrades,
                            ),
                            array(
                                'taxonomy' => 'cyclon_product_cat',
                                'field' => 'term_id',
                                'terms' => $postTermsObj[0]->term_id
                            ),
                        );
                    endif;
                }
                if ($r == 'soap') {
                    $postSoapsObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_soap');
                    if (!empty($postSoapsObj)):
                        echo $postSoaps = $postSoapsObj[0]->term_id;
                    endif;
                }
                if ($r == 'nlgi') {
                    $postNlgiObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_nlgi');
                    if (!empty($postNlgiObj)):
                        echo $postNlgi = $postNlgiObj[0]->term_id;
                    endif;
                }
            }

        else:

            $postTermsObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_cat');

            if (!empty($postTermsObj)):
                $postTerms = $postTermsObj[0]->term_id;
            endif;

            $relatedArgs = array(
                'post_type' => 'cyclon_product',
                'posts_per_page' => 10,
                'post__not_in' => [get_the_ID()],
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'cyclon_product_cat',
                        'field' => 'term_id',
                        'terms' => $postTerms
                    ),

                )
            );
        endif;

        // Execute query
        $relatedQuery = new WP_Query($relatedArgs);

        // Only render section if there are related products
        if ($relatedQuery->have_posts()): ?>
            <div class="cyclon_single__relatedWrapper">
                <h3 class="relatedTitle text-center"><?php echo esc_html__('Similar Products', 'cyclon'); ?></h3>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="relatedProducts__SuperWrapper">
                                <div class="relatedProducts__Wrapper swiper">
                                    <div class="relatedProducts__Inner swiper-wrapper">
                                        <?php while ($relatedQuery->have_posts()): $relatedQuery->the_post(); ?>
                                            <div class="swiper-slide">
                                                <div class="relatedProduct productCard">
                                                    <div class="productCard__Image">
                                                        <?php
                                                        $im = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                        if (!empty($im)): ?>
                                                            <img src="<?php echo $im; ?>"
                                                                class="img-fluid" />
                                                        <?php else: ?>
                                                            <img src="/wp-content/uploads/2022/05/1L_MAGMA-SYN-ULTRA-S-0W-20-1.png"
                                                                class="img-fluid" />
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="productCard__Content">
                                                        <h3><?php the_title(); ?></h3>
                                                        <!--                                                    <p class="spec"><strong>SYN - SHPD PLUS </strong> / 10W - 40</p>-->
                                                        <p class="info"><?php echo get_field('small_text_line'); ?></p>
                                                    </div>
                                                    <a href="<?php the_permalink(); ?>" class="productCard__Link"></a>
                                                </div>
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
