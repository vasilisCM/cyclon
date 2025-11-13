<?php
/*
 * Template Name: Contact
 */
get_header(); ?>
    <main id="primary" class="main-content cyclon_customer_support cyclon_contact" style="background-size: cover;">
        <div class="contact__top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if (get_field('contact_main_title')): ?>
                        <h2 class="contact__title text-center">
                            <?php echo get_field('contact_main_title'); ?>
                        </h2>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <?php if (get_field('opening_time')): ?>
                            <div class="contact__info opening-info">
                                <?php echo get_field('opening_time'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('address')): ?>
                            <div class="contact__info address-info">
                                <?php echo get_field('address'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                        <div class="contact__content">
                            <?php echo get_field('contact_content'); ?>
                        </div>
                    </div>
<!-- 
                    <div class="col-12 text-center">
                        <div class="contactLine">
                            <div class="contactLine__Inner">
                                <span class="contactLine__text">
                                    <?php // echo __('CALL US', 'cyclon'); ?>
                                </span>
                                <span class="contactLine__phone">
                                    <a href="tel:801801111">
                                        <?php // echo __('801 801 1111', 'cyclon'); ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div> -->

                    <h2 class="contact__title text-center">
                        <?php echo get_field('form_title'); ?>
                    </h2>

                </div>
                <div class="row">
                    <div class="contact-container">
                        <?php
                        $formSC = get_field('form_shortcode');
                        echo do_shortcode($formSC); ?>

                    </div>
                </div>
            </div>

        </div>
    </main>
<?php get_footer();