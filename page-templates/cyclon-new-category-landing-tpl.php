<?php
/*
 * Template Name: New Category Landing
 */
$term = get_queried_object();
get_header(); ?>
<main id="primary" class="main-content cyclon_product_category_content">

    <section class="saloon new-category-landing">
        <?php
        $has_products_with_range = get_field('has_product_range');
        $saloon_btn_link = get_field('saloon_btn_url');
        $range_terms = array();

        if (!$has_products_with_range) : ?>
            <div class="saloon__Image">
                <img src="<?php echo get_field('saloon_image'); ?>" class="img-responsive" />
            </div>
            <h3 class="text-center"><?php echo get_field('saloon_title'); ?></h3>
            <p class="text-center"><?php echo get_field('saloon_text'); ?></p>
        <?php else : ?>
            <?php
            $saloon_term = null;

            if ($saloon_btn_link) {
                $path = trim(parse_url($saloon_btn_link, PHP_URL_PATH), '/');
                $segments = array_filter(explode('/', $path));
                $possible_slug = end($segments);

                if ($possible_slug) {
                    $saloon_term = get_term_by('slug', $possible_slug, 'cyclon_product_cat');
                }
            }

            $allowed_range_slugs = array('evo', 'pro', 'eco', 'max');

            foreach ($allowed_range_slugs as $allowed_slug) {
                $range_term = get_term_by('slug', $allowed_slug, 'cyclon_range');
                if ($range_term && !is_wp_error($range_term)) {
                    $range_terms[] = $range_term;
                }
            }
            ?>
            <div>
                <h1>
                    <?php
                    if ($saloon_term && !is_wp_error($saloon_term)) {
                        echo esc_html($saloon_term->slug);
                    } else {
                        echo esc_html($saloon_btn_link);
                    }
                    ?>
                </h1>
                <?php
                $category_term_id = ($saloon_term && !is_wp_error($saloon_term)) ? $saloon_term->term_id : 0;
                ?>

                <?php if (!empty($range_terms) && !is_wp_error($range_terms)) : ?>
                    <?php
                    // Pre-filter range terms to only include those with products
                    $featured_group = get_field('new_product_landing_featured_products');
                    $filtered_range_terms = array();

                    foreach ($range_terms as $range_term) {
                        $range_key = sanitize_key($range_term->slug);
                        $featured_raw = (is_array($featured_group) && isset($featured_group[$range_key])) ? $featured_group[$range_key] : array();

                        if (!is_array($featured_raw)) {
                            $featured_raw = array($featured_raw);
                        }

                        // Check if this range has any valid product IDs
                        $has_products = false;
                        foreach ($featured_raw as $item) {
                            $post_id = 0;

                            if (is_numeric($item)) {
                                $post_id = (int) $item;
                            } elseif (is_object($item) && isset($item->ID)) {
                                $post_id = (int) $item->ID;
                            } elseif (is_string($item) && $item !== '') {
                                $post_id = (int) url_to_postid($item);
                            }

                            if ($post_id > 0) {
                                $has_products = true;
                                break;
                            }
                        }

                        // Only add this range if it has products
                        if ($has_products) {
                            $filtered_range_terms[] = $range_term;
                        }
                    }
                    ?>

                    <?php if (!empty($filtered_range_terms)) : ?>
                        <div class="tabs new-category-landing__tabs">
                            <div class="tabs__buttons new-category-landing__tabs-buttons">
                                <span class="white new-category-landing__tabs-buttons-label"><?php echo __('select product range: ', 'cyclon'); ?></span>
                                <?php
                                $tab_index = 0;
                                foreach ($filtered_range_terms as $range_term) :
                                    $button_classes = 'tabs__button tabs__button--' . $range_term->slug;
                                    if ($tab_index === 0) {
                                        $button_classes .= ' tabs__button--active';
                                    }
                                ?>
                                    <div class="<?php echo esc_attr($button_classes); ?>"
                                        data-tab-target="tab-<?php echo esc_attr($range_term->slug); ?>"
                                        data-range="<?php echo esc_attr($range_term->slug); ?>">
                                        <?php echo esc_html($range_term->name); ?>
                                    </div>
                                <?php
                                    $tab_index++;
                                endforeach;
                                ?>
                            </div>

                            <div class="tabs__contents">
                                <?php


                                $tab_index = 0;
                                foreach ($filtered_range_terms as $range_term) :
                                    $content_classes = 'tabs__content';
                                    if ($tab_index !== 0) {
                                        $content_classes .= ' tabs__content--hidden';
                                    }

                                    // Get the associated category ID from the field
                                    $associated_cat_id = get_field('product_category_landing__assosiated_category');
                                    /**
                                     * Featured products (ACF) instead of WP_Query
                                     * Group field: new_product_landing_featured_products
                                     * Subfields (Page Link, multiple): EVO, PRO, ECO, MAX
                                     *
                                     * We normalize whatever Page Link returns (ID | Post Object | URL)
                                     * into an array of product post IDs.
                                     */
                                    $featured_group = get_field('new_product_landing_featured_products');
                                    $range_key = sanitize_key($range_term->slug); // expected: evo|pro|eco|max
                                    $featured_raw = (is_array($featured_group) && isset($featured_group[$range_key])) ? $featured_group[$range_key] : array();
                                    if (!is_array($featured_raw)) {
                                        $featured_raw = array($featured_raw);
                                    }

                                    $featured_product_ids = array();
                                    foreach ($featured_raw as $item) {
                                        $post_id = 0;

                                        if (is_numeric($item)) {
                                            $post_id = (int) $item;
                                        } elseif (is_object($item) && isset($item->ID)) {
                                            $post_id = (int) $item->ID;
                                        } elseif (is_string($item) && $item !== '') {
                                            $post_id = (int) url_to_postid($item);
                                        }

                                        if ($post_id > 0) {
                                            $featured_product_ids[] = $post_id;
                                        }
                                    }

                                    $featured_product_ids = array_values(array_unique($featured_product_ids));
                                    if (count($featured_product_ids) > 3) {
                                        $featured_product_ids = array_slice($featured_product_ids, 0, 3);
                                    }
                                ?>
                                    <div class="<?php echo esc_attr($content_classes); ?> primary" id="tab-<?php echo esc_attr($range_term->slug); ?>">

                                        <div class="text-center boxed-sm centered new-category-landing__dynamic-texts no-padding">
                                            <!-- Product Category Description  -->
                                            <div class="text new-category-landing__dynamic-texts__description">
                                                <?php
                                                if ($associated_cat_id) {
                                                    // Get the term object by ID from cyclon_new_product_cat taxonomy.
                                                    $cat_term = get_term($associated_cat_id, 'cyclon_new_product_cat');
                                                    if (! is_wp_error($cat_term) && ! empty($cat_term) && isset($cat_term->description)) {
                                                        echo wpautop($cat_term->description);
                                                    }
                                                }
                                                ?>
                                            </div>

                                            <div>
                                                <div class="text-l regular sans normal">
                                                    <?php echo esc_html($range_term->name); ?> Line
                                                </div>
                                                <div class="text-m">
                                                    <?php echo wpautop($range_term->description); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Products  -->
                                        <div class="boxed centered no-padding">
                                            <?php if (!empty($featured_product_ids)) : ?>
                                                <?php
                                                // Fetch the color field from the range term
                                                $range_color = get_field('color', $range_term);
                                                ?>
                                                <div class="range-group primary" data-range="<?php echo esc_attr($range_term->slug); ?>">

                                                    <div class="new-category-product-grid">
                                                        <?php
                                                        foreach ($featured_product_ids as $featured_product_id) :
                                                            $post_obj = get_post($featured_product_id);
                                                            if (!$post_obj) {
                                                                continue;
                                                            }

                                                            setup_postdata($post_obj);

                                                            // Retrieve custom fields first
                                                            $range_code = get_field('range_code', $featured_product_id);
                                                            $small_text_line = get_field('small_text_line', $featured_product_id);
                                                            $thumbnail_url = get_the_post_thumbnail_url($featured_product_id, 'large');
                                                        ?>
                                                            <a href="<?php echo esc_url(get_permalink($featured_product_id)); ?>" class="new-category-product-card">

                                                                <?php if ($thumbnail_url) : ?>
                                                                    <div class="new-category-product-card__img-container">
                                                                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title($featured_product_id)); ?>">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="new-category-product-card__text-container">
                                                                    <div>
                                                                        <div class="sans regular range-group__title uppercase text-ms">Cyclon <?php echo esc_html($range_term->name); ?></div>
                                                                        <h5 class="text-l regular primary sans new-category-product-card__title">
                                                                            <?php echo get_the_title($featured_product_id); ?>
                                                                        </h5>
                                                                        <?php
                                                                        $grade_terms = get_the_terms($featured_product_id, 'cyclon_product_grade');
                                                                        if (!empty($grade_terms) && !is_wp_error($grade_terms)) {
                                                                            $color_style = '';
                                                                            if ($range_color) {
                                                                                $color_style = ' style="color: ' . esc_attr($range_color) . ';"';
                                                                            }
                                                                        ?>
                                                                            <div class="text-l uppercase product-card__grade" <?php echo $color_style; ?>><?php echo $grade_terms[0]->name; ?></div>
                                                                        <?php } ?>
                                                                        <?php if ($range_code) : ?>
                                                                            <div class="text-l regular sans new-category-product-card__code" style="color: <?php echo esc_attr($range_color); ?>;"><?php echo esc_html($range_code); ?></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <?php if ($small_text_line) : ?>
                                                                        <div class="text-sm new-category-product-card__text"><?php echo esc_html($small_text_line); ?></div>
                                                                    <?php endif; ?>

                                                                    <?php
                                                                    $content = strip_tags(get_post_field('post_content', $featured_product_id));
                                                                    $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
                                                                    $short_content = implode(' ', array_slice($words, 0, 15));
                                                                    ?>
                                                                    <div class="text-sm info product-card__info">
                                                                        <?php echo esc_html($short_content); ?><?php if (count($words) > 15) echo '...'; ?>
                                                                    </div>

                                                                    <h4 class="home-categories__category-heading">
                                                                        <span></span>
                                                                    </h4>
                                                                </div>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="range-group range-group--empty" data-range="<?php echo esc_attr($range_term->slug); ?>">
                                                    <p><?php echo esc_html__('', 'cyclon'); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php
                                    wp_reset_postdata();
                                    $tab_index++;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
        $default_range_slug = '';
        $filtered_saloon_url = $saloon_btn_link;

        if ($has_products_with_range && !empty($filtered_range_terms)) {
            $default_range_slug = $filtered_range_terms[0]->slug;

            if ($saloon_btn_link && $default_range_slug) {
                $filtered_saloon_url = add_query_arg('cyclon_range', $default_range_slug, $saloon_btn_link);
            }
        }
        ?>
        <?php
        $associated_cat_id = get_field('product_category_landing__assosiated_category');
        $has_products = false;

        if ($associated_cat_id) {
            // Check if there are any products in this category
            $check_products_query = new WP_Query(array(
                'post_type' => 'cyclon_new_product',
                'posts_per_page' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cyclon_new_product_cat',
                        'field'    => 'term_id',
                        'terms'    => $associated_cat_id,
                    ),
                ),
            ));

            $has_products = $check_products_query->have_posts();
            wp_reset_postdata();

            if ($has_products) {
                $category_link = get_term_link($associated_cat_id, 'cyclon_new_product_cat');
                if (!is_wp_error($category_link)) {
        ?>
                    <div class="text-center">
                        <a class="mButton primary product-category-landing__cta"
                            href="<?php echo esc_url($category_link); ?>">
                            View Products
                        </a>
                    </div>
        <?php
                }
            }
        }
        ?>
    </section>

    <?php if (get_field('mapping_information')): ?>
        <section class="appMapping default" id="mappingSection">
            <div class="container d-none d-md-block">
                <div class="row">

                    <?php
                    if (have_rows('mapping_information') && count(get_field('mapping_information')) > 1) :
                    ?>
                        <div class="mapping-tabs-wrapper">
                            <?php
                            $countTab = 1;
                            $countSingleTab = 1;
                            $countMainTab = 0;
                            $rowNumber = -1;
                            $countAll = 1;
                            while (have_rows('mapping_information')) : the_row();
                                if (get_sub_field('general_category')) :
                                    $previousRow = get_field('mapping_information')[$rowNumber];
                                    $currRow = get_field('mapping_information')[$rowNumber + 1];
                                    $previousCat = $previousRow['general_category'];
                                    $currCat = $currRow['general_category'];
                                    if (strcmp($previousCat, $currCat) != 0) :
                                        $countSingleTab = 1;
                                        $countMainTab++;
                            ?>
                                        <div class="main-tab single-tab<?php if ($countTab == 1) {
                                                                            echo " active";
                                                                        } ?>" id="single-mapping-<?php echo $countTab++; ?>"><?php echo get_sub_field('general_category_front'); ?></div>
                                    <?php
                                    endif;
                                    ?>
                                    <div class="single-tab single-mapping-<?php echo $countMainTab; ?><?php if ($countMainTab == 1) {
                                                                                                            echo " active";
                                                                                                        } ?>" id="single-mapping-<?php echo $countAll++; ?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>"><span><?php echo get_sub_field('general_title_front'); ?></span></div>
                                <?php
                                    $countSingleTab++;
                                    $rowNumber++;
                                else :
                                ?>
                                    <div class="single-tab gen<?php if ($countTab == 1) {
                                                                    echo " active";
                                                                } ?>" id="single-mapping-<?php echo $countTab++; ?>"><?php echo get_sub_field('general_title_front'); ?></div>
                                <?php
                                endif;
                                ?>

                            <?php
                            endwhile;
                            ?>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="col-4">
                        <div class="content-wrapper">
                            <h2><?php echo __('Cyclon products per application', 'cyclon') ?></h2>
                            <div class="oil-wrapper-outer">
                                <h3></h3>
                                <div class="oil-wrapper">
                                    <div class="oil-content">
                                    </div>
                                    <div class="oil-image">
                                        <?php ?>
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
                            <a class="mButton mButton--trans" href="<?php echo esc_url($category_link); ?>"><?php echo __('SIMILAR PRODUCTS', 'cyclon') ?> </a>


                        </div>
                    </div>
                    <div class="col-8">
                        <?php
                        if (have_rows('mapping_information')):
                            $count = 1;

                            $countTab = 1;
                            $countSingleTab = 1;
                            $countMainTab = 0;
                            $rowNumber = -1;
                            $countAll = 1;
                            while (have_rows('mapping_information')) : the_row();
                                if (get_sub_field('general_category')) :
                                    $previousRow = get_field('mapping_information')[$rowNumber];
                                    $currRow = get_field('mapping_information')[$rowNumber + 1];
                                    $previousCat = $previousRow['general_category'];
                                    $currCat = $currRow['general_category'];
                                    if (strcmp($previousCat, $currCat) != 0) :
                                        $countSingleTab = 1;
                                        $countMainTab++;
                        ?>
                                        <div class="single-mapping-wrapper<?php if ($countMainTab == 1) {
                                                                                echo " active";
                                                                            } ?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field('general_title'))); ?>" id="content-single-mapping-<?php echo $countAll++; ?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>">
                                        <?php
                                    else:
                                        ?>
                                            <div class="single-mapping-wrapper<?php if ($countMainTab == 1) {
                                                                                    echo " active";
                                                                                } ?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field('general_title'))); ?>" id="content-single-mapping-<?php echo $countAll++; ?>-<?php echo $countMainTab; ?>-<?php echo $countSingleTab; ?>">
                                            <?php
                                        endif;
                                        $countSingleTab++;
                                        $rowNumber++;
                                    else:
                                            ?>
                                            <div class="single-mapping-wrapper <?php if ($count == 1) {
                                                                                    echo "active";
                                                                                } ?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field('general_title'))); ?>" id="content-single-mapping-<?php echo $count++; ?>">
                                            <?php
                                        endif; ?>

                                            <div class="image-wrapper" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');">
                                                <div class="default-image" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                                <div class="hidden-field" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                                <span class="line-x"></span>
                                                <span class="line-y"></span>
                                                <?php
                                                if (have_rows('part_details')):
                                                    while (have_rows('part_details')) : the_row();
                                                        $idname = strtolower(get_sub_field('part_title'));
                                                        $idname = preg_replace('/\s+/', '-', $idname);
                                                ?>
                                                        <span class="dots" id="<?php echo $idname; ?>"></span>
                                                <?php
                                                    endwhile;
                                                endif;
                                                ?>
                                            </div>
                                            </div>
                                    <?php
                                endwhile;
                            endif;
                                    ?>
                                            </div>
                                        </div>
                    </div>
                    <div class="container d-block d-md-none">
                        <?php
                        if (have_rows('mapping_information')):
                            $repeater = get_field('mapping_information');
                        ?>
                            <div class="row">
                                <div class="col-12 <?php echo preg_replace('/\s+/', '-', strtolower($repeater[0]['general_title'])); ?>">
                                    <h2><?php echo __('Cyclon products per application', 'cyclon') ?></h2>

                                    <?php $c = 1;
                                    while (have_rows('mapping_information')) : the_row(); ?>
                                        <div class="image-main-wrap<?php if ($c == 1) {
                                                                        echo ' active';
                                                                    } ?> <?php echo preg_replace('/\s+/', '-', strtolower(get_sub_field('general_title'))); ?>">
                                            <div class="image-wrapper<?php if ($c == 1) {
                                                                            echo ' active';
                                                                        }
                                                                        $c++; ?>" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');">
                                                <div class="default-image" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                                <div class="hidden-field" style="background-image: url('<?php echo get_sub_field('general_image'); ?>');"></div>
                                                <?php
                                                while (have_rows('part_details')) : the_row();
                                                    $idname = strtolower(get_sub_field('part_title'));
                                                    $idname = preg_replace('/\s+/', '-', $idname);
                                                ?>
                                                    <span class="dots" id="<?php echo $idname; ?>"></span>
                                                <?php
                                                endwhile;
                                                ?>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                    <?php
                                    if (have_rows('mapping_information') && count(get_field('mapping_information')) > 1) :
                                    ?>
                                        <div class="custom-select main-select">
                                            <select>
                                                <?php
                                                $countTab = 0;
                                                $countSingleTab = 1;
                                                $countMainTab = 0;
                                                $rowNumber = -1;
                                                $countAll = 1;
                                                while (have_rows('mapping_information')) : the_row();
                                                    $idname = strtolower(get_sub_field('general_title'));
                                                    if (get_sub_field('general_category')) :
                                                        $previousRow = get_field('mapping_information')[$rowNumber];
                                                        $currRow = get_field('mapping_information')[$rowNumber + 1];
                                                        $previousCat = $previousRow['general_category'];
                                                        $currCat = $currRow['general_category'];

                                                        if (strcmp($previousCat, $currCat) != 0) :
                                                            $countSingleTab = 1;
                                                            $countMainTab++;

                                                ?>
                                                            <option value="<?php echo $countTab++; ?>" id="option-<?php echo get_sub_field('general_category'); ?>" class="main-tab"><?php echo get_sub_field('general_category_front'); ?></option>
                                                        <?php
                                                        endif;

                                                        ?>
                                                        <option value="<?php echo $countTab++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field('general_title_front'); ?></option>
                                                    <?php
                                                        $countSingleTab++;
                                                        $rowNumber++;
                                                    else :
                                                    ?>
                                                        <option value="<?php echo $countTab++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field('general_title_front'); ?></option>
                                                <?php
                                                    endif;
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                    <?php $c = 1;
                                    while (have_rows('mapping_information')) : the_row(); ?>
                                        <div class="custom-select gen-select<?php if ($c == 1) {
                                                                                echo ' active';
                                                                            }
                                                                            $c++; ?>">
                                            <select>
                                                <option value="0"><?php echo __('Please select', 'cyclon'); ?></option>
                                                <?php
                                                while (have_rows('part_details')) : the_row();
                                                    $idname = strtolower(get_sub_field('part_title'));
                                                    $idname = preg_replace('/\s+/', '-', $idname);
                                                ?>
                                                    <option value="<?php echo $count++; ?>" id="option-<?php echo $idname; ?>"><?php echo get_sub_field('part_title_front'); ?></option>
                                                <?php
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                    <?php endwhile; ?>

                                    <div class="oil-details">
                                        <div class="oil-content"></div>
                                        <div class="oil-image"><img src="" alt=""></div>
                                    </div>
                                    <a class="mButton mButton--trans" href="<?php echo esc_url($category_link); ?>"><?php echo __('SIMILAR PRODUCTS', 'cyclon') ?> </a>


                                </div>

                            </div>
                        <?php
                        //endwhile;
                        endif;
                        ?>
                    </div>
        </section>
    <?php endif; ?>

    <?php
    $hasFeatures = get_field('has_features');
    if ($hasFeatures): ?>

        <section class="features">



            <!-- This is going to override the below features -->

            <?php if (have_rows('new_features')):
                while (have_rows('new_features')): the_row('new_features');

                    if (get_row_layout() == 'left_image_feature'):
                        get_template_part('template-parts/layouts/acf-left-image', 'tpl');
                    elseif (get_row_layout() == 'right_image_feature'):
                        get_template_part('template-parts/layouts/acf-right-image', 'tpl');
                    elseif (get_row_layout() == 'tribo_act_feature'):
                        get_template_part('template-parts/layouts/acf-tribo', 'tpl');
                    elseif (get_row_layout() == 'video_section_feature'):
                        get_template_part('template-parts/layouts/acf-video-section', 'tpl');
                    endif;
                endwhile;
            endif;
            ?>


            <?php
            $feature1 = get_field('feature_1');
            $feature2 = get_field('feature_2');
            ?>
            <?php if (array_filter($feature1)): ?>
                <div class="feature feature--leftImage">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Content">
                                    <h3><?php echo $feature1['feature_title']; ?></h3>
                                    <p>
                                        <?php echo $feature1['feature_content']; ?>
                                    </p>

                                    <a class="mButton mButton--blueButton"
                                        href="<?php echo $feature1['feature_button_url']; ?>">
                                        <?php echo $feature1['feature_button_text']; ?>
                                    </a>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Image">
                                    <img src="<?php echo $feature1['feature_image']; ?>" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (array_filter($feature2)): ?>
                <div class="feature feature--rightImage">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Image">
                                    <img src="<?php echo $feature2['feature_image']; ?>" class="img-fluid" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="feature__Content">
                                    <h3><?php echo $feature2['feature_title']; ?></h3>
                                    <p>
                                        <?php echo $feature2['feature_content']; ?>
                                    </p>

                                    <a class="mButton mButton--blueButton"
                                        href="<?php echo $feature2['feature_button_url']; ?>">
                                        <?php echo $feature2['feature_button_text']; ?>
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


        </section>

    <?php endif; ?>
</main>

<?php
$hasTriboActBanner = get_field('has_tribo_act_section');
if ($hasTriboActBanner): ?>
    <?php get_template_part('template-parts/components/tribo-act-banner', 'tpl'); ?>
<?php endif; ?>

<?php
get_footer();
