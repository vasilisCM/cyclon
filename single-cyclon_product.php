<?php
get_header();

if (have_posts()): while (have_posts()): the_post();
    ?>
    <main id="primary" class="main-content cyclon_single_product">
        <div class="cyclon_product__Inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="cyclon_product__Gallery">
                            <div class="cyclon_product__Gallery__Inner">
                                <!--                                --><?php //if (has_post_thumbnail()):
                                //                                    the_post_thumbnail('full', array('class' => 'img-fluid'));
                                //                                endif; ?>

                                <img src="/wp-content/uploads/2022/06/shine-grey.png" class="glow"/>


                                <!-- Gallery Test -->
                                <?php
                                $gallery = get_field('image_gallery');

                                $mainImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                if (!empty($mainImage)):?>
                                    <div class="productGallery__SuperWrapper" style="position: relative;">
                                        <div class="productGallery__Wrapper swiper">
                                            <div class="productGallery__Inner swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <a href="#" data-fancybox="gallery"
                                                       data-src="<?php echo $mainImage; ?>">
                                                        <img src="<?php echo $mainImage; ?>" class="img-fluid"/>
                                                    </a>
                                                </div>
                                                <?php if (have_rows('image_gallery')):
                                                    while (have_rows('image_gallery')): the_row('image_gallery'); ?>
                                                        <div class="swiper-slide">
                                                            <a href="#" data-fancybox="gallery"
                                                               data-src="<?php echo get_sub_field('gallery_image'); ?>">
                                                                <img src="<?php echo get_sub_field('gallery_image'); ?>"
                                                                     class="img-fluid"/>
                                                            </a>

                                                        </div>
                                                    <?php endwhile;
                                                endif; ?>
                                            </div>
                                        </div>
                                        <?php if (sizeof($gallery) > 1): ?>
                                            <div class="swiper-pagination">
                                                <div class="swiper-button-carousel-prev">

                                                    <svg id="Group_16567" data-name="Group 16567"
                                                         xmlns="http://www.w3.org/2000/svg" width="46" height="46"
                                                         viewBox="0 0 46 46">
                                                        <circle id="Ellipse_249" data-name="Ellipse 249" cx="23" cy="23"
                                                                r="23" fill="#fff" opacity="0.23"/>
                                                        <path id="Path_24822" data-name="Path 24822"
                                                              d="M6.508,13.016,0,6.508,6.508,0"
                                                              transform="translate(19.567 16.163)" fill="none"
                                                              stroke="#000"
                                                              stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="1.5"/>
                                                    </svg>

                                                </div>
                                                <div class="swiper-button-carousel-next">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46"
                                                         viewBox="0 0 46 46">
                                                        <g id="Group_16566" data-name="Group 16566"
                                                           transform="translate(-830 -508)">
                                                            <circle id="Ellipse_249" data-name="Ellipse 249" cx="23"
                                                                    cy="23"
                                                                    r="23" transform="translate(876 554) rotate(180)"
                                                                    fill="#fff" opacity="0.23"/>
                                                            <path id="Path_24822" data-name="Path 24822"
                                                                  d="M-3738.142-13022.2l-6.508,6.508,6.508,6.508"
                                                                  transform="translate(-2888.217 -12485.022) rotate(180)"
                                                                  fill="none" stroke="#000" stroke-linecap="round"
                                                                  stroke-linejoin="round" stroke-width="1.5"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div>


                                    <?php if (sizeof($gallery) > 1) { ?>
                                        <div class="productGallery__thumbs swiper">
                                            <div class="productGallery__thumbs__Inner swiper-wrapper">
                                                <?php
                                                $mainImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                if (!empty($mainImage)):?>
                                                    <div class="productGallery__thumb swiper-slide">
                                                        <div class="productThumb">
                                                            <img src="<?php echo $mainImage; ?>" class="img-fluid"/>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if (have_rows('image_gallery')):
                                                    while (have_rows('image_gallery')): the_row('image_gallery'); ?>

                                                        <div class="productGallery__thumb swiper-slide">
                                                            <div class="productThumb">
                                                                <img src="<?php echo get_sub_field('gallery_image'); ?>"
                                                                     class="img-fluid"/>
                                                            </div>
                                                        </div>
                                                    <?php endwhile; ?>

                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="cyclon_product__Content">
                            <!-- Breadcrumbs -->
                            <?php
                            if (function_exists('yoast_breadcrumb')) {
                                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                            }
                            ?>
                            <h1><?php the_title(); ?></h1>
                            <div class="product-subtitle"><?php echo get_field('small_text_line') ?></div>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>

                            <div class="product-specs">
                                <?php if (have_rows('specifcation_packaging')): ?>
                                    <?php
                                    $tabCounter = 1;
                                    while (have_rows('specifcation_packaging')): the_row(); ?>
                                        <div class="specTab <?php echo($tabCounter == 1 ? ' specTab--active' : ''); ?>">
                                            <a href="#"
                                               class="specTab__Heading<?php echo($tabCounter == 1 ? ' specTab__Heading--active' : ''); ?>"
                                               data-tab="<?php echo $tabCounter; ?>">
                                                <?php echo get_sub_field('spec_title'); ?>
                                            </a>
                                            <div id="sTab_<?php echo $tabCounter; ?>" class="specTab__Content">
                                                <?php echo get_sub_field('spec_text'); ?>
                                            </div>
                                        </div>
                                        <?php $tabCounter++;
                                    endwhile; ?>
                                <?php endif; ?>
                            </div>

                            <?php if (have_rows('technical_guides')): ?>
                                <div class="product-buttons">
                                    <?php while (have_rows('technical_guides')): the_row('technical_guides'); ?>
                                        <a href="<?php echo get_sub_field('guide_pdf'); ?>" class="product-pill"
                                           target="_blanks">
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
                        </div>
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

                                foreach($postTypesObj as $pg){
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
                                foreach($postGradesObj as $pg){
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

                    if ($relatedQuery->have_posts()):?>

                        <div class="relatedProducts__SuperWrapper">
                            <div class="relatedProducts__Wrapper swiper">
                                <div class="relatedProducts__Inner swiper-wrapper">
                                    <?php while ($relatedQuery->have_posts()): $relatedQuery->the_post(); ?>
                                        <div class="swiper-slide">
                                            <div class="relatedProduct productCard">
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
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>

<?php endwhile; endif; ?>


<?php
get_footer();