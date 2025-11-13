<?php
/*
 * Template Name: Brand
 */
get_header(); ?>
<main id="primary" class="main-content cyclon_blog cyclon_brand">

    <!-- Main Brand Image -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="main-image">
                    <?php if (get_field('main_products_image')): ?>
                        <img src="<?php echo get_field('main_products_image'); ?>" class="img-fluid" />
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Values -->
    <section class="brandValues"
        style="background: url('/wp-content/uploads/2025/06/brand-values.jpg') center no-repeat; background-size:cover;">
        <div class="brandValues__Content">


            <div>
                <h3 class="white-text"><?php echo __('Brand Values', 'cyclon'); ?></h3>
                <p class="brandValues__subHeading accent"><?php echo __('Technology - Innovation - Enviroment - Economy', 'cyclon'); ?></p>
                <p class="brandValues__text secondary">
                    <?php echo get_field('brand_value_text'); ?></p>
            </div>

        </div>
    </section>


    <section class="lpc">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="lpc__left">
                        <img src="<?php echo get_field('lpc_image'); ?>" class="img-fluid" />
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="lpc__right">
                        <a href="<?php echo get_field('small_logo_url'); ?>" title="LPC | Lubricants and Petroleum Corporation" target="_blank"><img src="<?php echo get_field('small_logo'); ?>" class="img-fluid" /></a>
                        <div class="smallContent">
                            <?php echo get_field('text'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="brandHistory">
        <h3 class="fullTitle">
            <?php echo get_field('brand_title'); ?>
        </h3>
    </section>


    <!-- TIMELINE -->
    <div class="container">
        <div class="timelineContainer">
            <h3 class="timeline-title"><?php echo get_field('timeline-title'); ?></h3>

            <div class="timelineComponent">
                <?php if (have_rows('timeline')): $counter = 1; ?>
                    <div class="timelineComponent__inner">
                        <div class="timelineComponent__centerLine"></div>

                        <?php while (have_rows('timeline')): the_row(); ?>

                            <div class="timelineComponent__item item-<?php echo $counter; ?> <?php echo ($counter % 2 != 0 ? '--leftImage' : '--rightImage'); ?>">
                                <?php if ($counter % 2 != 0) { ?>
                                    <div class="timelineComponent__itemImage"
                                        data-aos-duration="800" <?php echo ($counter % 2 != 0 ? 'data-aos="fade-up"' : 'data-aos="fade-right"'); ?>>
                                        <img src="<?php the_sub_field('image'); ?>" class="img-responsive" />
                                    </div>
                                    <div class="timelineComponent__itemContent is-relative">
                                        <div class="rima"
                                            data-aos-duration="800" <?php echo ($counter % 2 != 0 ? 'data-aos="fade-left"' : 'data-aos="fade-up"'); ?>>
                                            <div class="timelineDate">
                                                <?php echo the_sub_field('year'); ?>
                                            </div>
                                            <div class="timelineContent">
                                                <?php echo the_sub_field('small_text'); ?>
                                            </div>
                                        </div>

                                    </div>
                                <?php } else { ?>

                                    <div class="timelineComponent__itemContent is-relative"
                                        data-aos-duration="800" <?php echo ($counter % 2 != 0 ? 'data-aos="fade-left"' : 'data-aos="fade-up"'); ?>>
                                        <div class="timelineComponent__itemImage show-786">
                                            <img src="<?php the_sub_field('image'); ?>" class="img-responsive" />
                                        </div>
                                        <div class="rima">
                                            <div class="timelineDate">
                                                <?php echo the_sub_field('year'); ?>
                                            </div>
                                            <div class="timelineContent">
                                                <?php echo the_sub_field('small_text'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timelineComponent__itemImage hide-768"
                                        data-aos-duration="800" <?php echo ($counter % 2 != 0 ? 'data-aos="fade-up"' : 'data-aos="fade-right"'); ?>>
                                        <img src="<?php the_sub_field('image'); ?>" class="img-responsive" />
                                    </div>
                                <?php } ?>
                            </div>
                        <?php $counter++;
                        endwhile; ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
</main>
<?php
get_footer();
