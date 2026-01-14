<?php
get_header();

if (have_posts()): while (have_posts()): the_post();
?>
        <main id="primary" class="main-content cyclon_single_product_new">
            <div class="cyclon_product__Inner">
                <div class="container">
                    <div class="single-product-new__grid">                         
                                <div class="single-product-new__img-container">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>                           
                        
                            <div class="single-product-new__info">
                                <div>
                                    <h1 class="text-2xl primary single-product-new__title"><?php the_title(); ?></h1>
                                        <?php if (get_field('range_code')): ?>
                                        <div class="text-xl single-product-new__range-code">
                                            <?php echo get_field('range_code'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                            
                                <div class="single-product-new__content">
                                    <?php the_content(); ?>
                                </div>

                                <?php if (get_field('product_short_description')): ?>
                                    <div class="product-short-description">
                                        <?php echo get_field('product_short_description'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (have_rows('specifcation_packaging')): ?>
                                    <div class="product-specifications">
                                        <?php while (have_rows('specifcation_packaging')): the_row(); ?>
                                            <div class="specification-item">
                                                <div class="spec-title">
                                                    <?php echo get_sub_field('spec_title'); ?>
                                                </div>
                                                <div class="spec-text">
                                                    <?php echo get_sub_field('spec_text'); ?>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (have_rows('technical_guides')): ?>
                                    <div class="product-technical-guides">
                                        <?php while (have_rows('technical_guides')): the_row(); ?>
                                            <div class="technical-guide-item">
                                                <a href="<?php echo get_sub_field('guide_pdf'); ?>" target="_blank">
                                                    <span class="guide-name">
                                                        <?php echo get_sub_field('guide_name'); ?>
                                                    </span>
                                                    <span class="guide-type">
                                                        <?php echo get_sub_field('guide_type'); ?>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        
                    </div>
                </div>
            </div>
        </main>

        <div class="cyclon_single__relatedWrapper">
            <h3 class="relatedTitle text-center"><?php echo esc_html__('Similar Products', 'cyclon'); ?></h3>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                        $rel = get_field('related_glue');

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

                        //print_r($relatedArgs);



                        else:

                            $postTermsObj = wp_get_post_terms(get_the_ID(), 'cyclon_product_cat');

                            if (!empty($postTermsObj)):
                                $postTerms = $postTermsObj[0]->term_id;
                            endif;
                            //                        if (!empty($postTermsObj)):
                            //                            $postTypes = $postTypesObj[0]->term_id;
                            //                        endif;

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


                        $relatedQuery = new WP_Query($relatedArgs);

                        if ($relatedQuery->have_posts()): ?>

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
                                        <?php endwhile; ?>

                                    </div>


                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>

<?php endwhile;
endif; ?>


<?php
get_footer();
