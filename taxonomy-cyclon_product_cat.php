<?php
$term = get_queried_object();
get_header(); ?>
    <main id="primary" class="main-content cyclon_product_category_content">
        <div class="cyclon_tax_wrapper">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-filters">

                            <?php
                             $term = get_query_var('term');
                            if (($term == 'greases')||($term == 'greases-el')||($term == 'greases-ro')||($term == 'greases-bg')): ?>
                                <div class="product-filter-line">
                                    <div class="filter-label d-inline-block">
                                        <?php echo __('SOAPS:', 'cyclon'); ?>
                                    </div>
                                    <div class="filter-data">
                                        <?php echo do_shortcode('[facetwp facet="soaps"]'); ?>
                                    </div>
                                </div>

                                <div class="product-filter-line">
                                    <div class="filter-label d-inline-block">
                                        <?php echo __('NLGI:', 'cyclon'); ?>
                                    </div>
                                    <div class="filter-data">
                                        <?php echo do_shortcode('[facetwp facet="nlgi"]'); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="product-filter-line">
                                    <div class="filter-label d-inline-block">
                                        <?php echo __('GRADE:', 'cyclon'); ?>
                                    </div>
                                    <div class="filter-data">
                                        <?php echo do_shortcode('[facetwp facet="grade"]'); ?>
                                    </div>
                                </div>

                                <div class="product-filter-line">
                                    <div class="filter-label d-inline-block">
                                        <?php echo __('TYPE:', 'cyclon'); ?>
                                    </div>
                                    <div class="filter-data">
                                        <?php echo do_shortcode('[facetwp facet="type"]'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <?php

            if (have_posts()): ?>
                <div class="container">
                    <div class="row g-2">
                        <?php while (have_posts()): the_post(); ?>
                            <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                                <div class="relatedProduct productCard">
                                    <?php if (get_field('vehicle_type_icon')): ?>
                                        <img src="<?php echo get_field('vehicle_type_icon'); ?>" class="vehicle-icon"/>
                                    <?php endif; ?>
                                    <div class="productCard__Image">
                                        <?php
                                        $im = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        if (!empty($im)):?>
                                            <img src="<?php echo $im; ?>"
                                                 class="img-fluid"/>
                                        <?php else: ?>
                                            <img src="/wp-content/uploads/2022/05/1L_MAGMA-SYN-ULTRA-S-0W-20-1.png"
                                                 class="img-fluid"/>
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
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
<?php
get_footer();