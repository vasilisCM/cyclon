<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Thinktank
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="7FRscCzuTUFxryi6Fud8MB_quFWccedqsh__dqYpv50" />
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <link rel="icon" type="image/x-icon" href="/wp-content/uploads/2025/06/favicon-cyclon.svg">

    <?php wp_head(); ?>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("consent", "default", {
            ad_storage: "denied",
            ad_user_data: "denied",
            ad_personalization: "denied",
            analytics_storage: "denied",
            functionality_storage: "denied",
            personalization_storage: "denied",
            security_storage: "granted",
            wait_for_update: 2000,
        });
        gtag("set", "ads_data_redaction", true);
        gtag("set", "url_passthrough", true);
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-P5QXF2B3');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5QXF2B3"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div id="page" class="site">

        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'cyclon'); ?></a>

        <header id="masthead" class="site-header cyclon__Header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-6">
                        <a href="<?php echo home_url('/'); ?>" class="logoLink">
                            <img src="/wp-content/uploads/2025/06/logo.svg" class="img-responsive cyclon__logo" />
                        </a>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-6 col-6 headerRight">
                        <div class="header-language-search">
                            <div class="header-search">
                                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                                    <label>
                                        <span>Search for:</span>
                                        <input type="search" class="search-field" placeholder="Search…" value="" name="s" title="Search for:" />
                                    </label>
                                    <input type="submit" class="search-submit" value="Search" />
                                </form>
                            </div>
                            <div class="header-language-switcher">
                                <?php do_action('wpml_add_language_selector'); ?>
                            </div>
                        </div>
                        <?php get_template_part('template-parts/header/primary-nav-tpl'); ?>
                    </div>

                </div>
            </div>
        </header><!-- #masthead -->
        <?php if (is_front_page()): ?>
            <?php add_revslider('slider-1'); ?>
        <?php
        elseif (is_tax()): ?>
            <div class="taxHeader taxHeader2 product-cat"
                style="background-image: url(/wp-content/uploads/2022/06/product-tax-header-img.jpg);">
                <?php
                $term = get_queried_object();
                $tax_right_image = get_field('right_image', $term);
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="taxHeader__Content" style="justify-content: flex-start;">
                                <div class="taxHeader__Content__Inner">
                                    <h1><?php echo $term->name; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="headerImage_Wrapper" style="max-width: 100%;">
                                <img src="<?php echo $tax_right_image; ?>" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (is_category()):
            $termID = get_queried_object_id();
            $termObj = get_term_by('term_id', $termID, 'category');

        ?>
            <div class="taxHeader"
                style="background:url('https://cyclon-lpc.com/wp-content/uploads/2022/04/Group-17277.png') center no-repeat;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="taxHeader__Content">
                                <div class="taxHeader__Content__Inner">
                                    <div class="taxHeader_Header_Wrapper__Inner">
                                        <h1>
                                            <?php echo $termObj->name; ?>
                                        </h1>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (is_page() && !is_page('quality') && !is_page('tribo-act') && !is_page('technology') && !is_page_template('page-templates/cyclon-plain.php')):
            $term = get_queried_object();
            $headerImage = get_field('header_image');
        ?>
            <div class="taxHeader" style="background:url('<?php echo $headerImage; ?>') center no-repeat;">
                <?php if (is_page('brand') || is_page('contact')): ?>
                    <h1 class="brandHero__heading white-text">
                        <?php echo get_field('hero_text'); ?>
                    </h1>
                <?php endif; ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="taxHeader__Content">
                                <div class="taxHeader__Content__Inner">
                                    <?php if (get_field('header_image_title')): ?>
                                        <div class="taxHeader_Header_Wrapper__Inner">
                                            <?php if (!is_page('brand') && !is_page('contact')): ?>
                                                <h1>
                                                    <?php echo get_field('header_image_title'); ?>
                                                </h1>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="taxHeader_Header_Wrapper__Inner">
                                            <?php if (!is_page('brand')  && !is_page('contact')): ?>
                                                <h1>
                                                    <?php echo get_the_title(); ?>
                                                </h1>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="taxHeader__Buttons d-none d-sm-flex d-md-flex d-lg-flex d-xl-flex">
                                        <?php if (get_field('header_button_1_image', $term)): ?>
                                            <a href="<?php echo get_field('header_button_1_link', $term); ?>">
                                                <img src="<?php echo get_field('header_button_1_image'); ?>"
                                                    class="img-responsive" />
                                            </a>
                                        <?php endif; ?>

                                        <?php if (get_field('header_button_2_image', $term)): ?>
                                            <a href="<?php echo get_field('header_button_2_link', $term); ?>">
                                                <img src="<?php echo get_field('header_button_2_image'); ?>"
                                                    class="img-responsive" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobileTaxHeaderTitle">
                <?php $id = get_queried_object_id(); ?>
                <?php echo get_the_title(); ?>
            </div>
            <div class="taxHeader__Buttons d-flex d-sm-none d-md-none d-lg-none d-xl-none align-items-center justify-content-center"
                style="margin-top: -31px;">
                <?php if (get_field('header_button_1_image', $term)): ?>
                    <a href="<?php echo get_field('header_button_1_link', $term); ?>">
                        <img src="<?php echo get_field('header_button_1_image'); ?>"
                            class="img-responsive d-none" />
                    </a>
                <?php endif; ?>

                <?php if (get_field('header_button_2_image', $term)): ?>
                    <a href="<?php echo get_field('header_button_2_link', $term); ?>">
                        <img src="/wp-content/uploads/2022/06/Group-17233.png"
                            class="img-responsive" />
                    </a>
                <?php endif; ?>
            </div>
        <?php
        elseif (is_page('quality') || is_page('tribo-act') || is_page('technology') || is_page_template('page-templates/cyclon-plain.php')): ?>
            <div class="taxHeader taxHeader2"
                style="background: #042a5d; background-image:url(<?php echo get_field('header_image'); ?>)">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                            <div class="headerImage_Wrapper triboAct__HeaderImage">
                                <img src="<?php echo get_field('circle_image'); ?>" class="img-responsive" />
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="taxHeader__Content" style="justify-content: flex-start;">
                                <div class="taxHeader__Content__Inner">
                                    <?php if (get_field('header_image_title')): ?>
                                        <h1>
                                            <?php echo get_field('header_image_title'); ?>
                                        </h1>
                                    <?php else: ?>
                                        <h1>
                                            <?php echo get_the_title(); ?>
                                        </h1>
                                        <?php if (!is_page_template('page-templates/cyclon-plain.php')): ?>
                                            <div>
                                                <?php the_content(); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="taxHeader__Buttons">
                                        <?php if (get_field('header_button_1_image', $term)): ?>
                                            <a href="<?php echo get_field('header_button_1_link', $term); ?>">
                                                <img src="<?php echo get_field('header_button_1_image'); ?>"
                                                    class="img-responsive" />
                                            </a>
                                        <?php endif; ?>

                                        <?php if (get_field('header_button_2_image', $term)): ?>
                                            <a href="<?php echo get_field('header_button_2_link', $term); ?>">
                                                <img src="<?php echo get_field('header_button_2_image'); ?>"
                                                    class="img-responsive" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>