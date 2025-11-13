<?php
/*
 * Template Name: Tribo Act Page
 */
get_header(); ?>
<main id="primary" class="main-content cyclon_customer_support biggerPadding">

    <!-- What is it -->
    <section class="what-is-it">
        <div class="container">
            <div class="col-12 text-center">
                <h3 class="headline">
                    <?php echo get_field('what_title'); ?>
                </h3>
                <div class="what-is-it__content">
                    <?php echo get_field('what_content'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->

    <div class="triboActFeatures"
         style="background: url('/wp-content/uploads/2022/06/triboact-components-scaled.webp') center no-repeat; height: 490px ; background-size:cover;">
        <div class="container">
            <div class="col-12">
                <div class="triboActFeatures__content text-center">
                    <?php echo get_field('triboact_small_content'); ?>
                </div>

                <div class="triboActFeatures__figures">
                    <div class="row">
                        <?php if (have_rows('triboact_features')):
                            $counter = 1;
                            while (have_rows('triboact_features')): the_row(); ?>
                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                                    <div class="triboFeature text-center">
                                        <div class="triboFeature__Icon">
                                            <img src="<?php echo get_sub_field('icon'); ?>" class="img-fluid"/>
                                        </div>
                                        <div class="triboFeature__text">
                                            <?php echo get_sub_field('text'); ?>
                                        </div>
                                        <div class="cyclonDrop">
                                            <?php echo $counter; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php $counter++;
                            endwhile; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- FORMULA -->

    <div class="triboFormula">
        <div class="container">
            <div class="col-12 text-center">
                <h3 class="headline">
                    <?php echo get_field('triboact_title'); ?>
                </h3>
                <div class="triboFormula__content">
                    <?php echo get_field('triboact_small_content_2'); ?>
                </div>

                <div class="triboFigures">
                    <div class="row">
                        <?php if (have_rows('tribo_percentages')): ?>
                            <?php while (have_rows('tribo_percentages')): the_row('tribo_percentages'); ?>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="triboFigure">
                                        <div class="triboFigure__top">
                                            <?php echo get_sub_field('suptitle'); ?>
                                        </div>
                                        <div class="triboFigure__Number">
                                            <?php echo get_sub_field('number'); ?><sup>%</sup>
                                        </div>
                                        <div class="triboFigure__Description">
                                            <?php echo get_sub_field('description'); ?>
                                        </div>
                                        <div class="d-none d-sm-block d-xl-block d-md-block d-lg-block">
                                            <img src="/wp-content/uploads/2022/06/Path-24870.svg"
                                                 class="img-fluid"/>
                                        </div>
                                        <div class="d-block d-sm-none d-xl-none d-md-none d-lg-none">
                                            <img src="/wp-content/uploads/2022/06/Path-25410-1.svg"
                                                 class="img-fluid"/>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <section class="triboVideo">
        <div class="paste_the_video">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php echo get_field('paste_the_video'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
