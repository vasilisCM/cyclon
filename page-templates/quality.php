<?php
/*
 * Template Name: Quality
 */
get_header(); ?>
    <main id="primary" class="main-content cyclon_customer_support biggerPadding">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="customer_ctas text-center">
                        <?php
                        $buttons = get_field('buttons');
                        $leftBtn = $buttons['button_1_text'];
                        $middleBtn = $buttons['button_2_text'];
                        $rightBtn = $buttons['button_3_text'];

                        if (!empty($leftBtn)):?>
                            <a href="<?php echo esc_url($buttons['button_1_url']); ?>" class="bigCta">
                                <?php echo $buttons['button_1_text']; ?>
                            </a>
                        <?php endif;

                        if (!empty($middleBtn)):?>
                            <a href="<?php echo esc_url($buttons['button_2_url']); ?>" class="bigCta">
                                <?php echo $buttons['button_2_text']; ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($rightBtn)): ?>
                            <a href="<?php echo esc_url($buttons['button_3_url']); ?>" class="bigCta">
                                <?php echo $buttons['button_3_text']; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ISO -->

        <div id="iso" class="feature feature--leftImage iso-section d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Content">
                            <h3>ISO</h3>
                            <p>
                                <?php echo get_field('iso_small_text'); ?>
                            </p>

                            <?php if (get_field('iso_logos')):
                                $gal = get_field('iso_logos');
                                ?>
                                <div class="iso-logos">
                                    <?php foreach ($gal as $im): ?>
                                        <img src="<?php echo $im; ?>" class="img-fluid"/>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Image">
                            <img src="<?php echo get_field('iso_image'); ?>" class="img-fluid"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="iso" class="feature feature--leftImage iso-section d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Image">
                            <img src="<?php echo get_field('iso_image'); ?>" class="img-fluid"/>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Content">
                            <h3>ISO</h3>
                            <p>
                                <?php echo get_field('iso_small_text'); ?>
                            </p>

                            <?php if (get_field('iso_logos')):
                                $gal = get_field('iso_logos');
                                ?>
                                <div class="iso-logos">
                                    <?php foreach ($gal as $im): ?>
                                        <img src="<?php echo $im; ?>" class="img-fluid"/>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- APPROVALS -->

        <div id="approvals" class="feature feature--rightImage approvals-section ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Image">
                            <img src="<?php echo get_field('approval_image'); ?>" class="img-fluid"/>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Content">
                            <h3><?php echo get_field('approval_title'); ?></h3>
                            <p>
                                <?php echo get_field('approval_text'); ?>
                            </p>

                            <?php
                            $apBtn = get_field('approval_button_1');
                            $apBtn2 = get_field('approval_button_2');
                            $apBtn3 = get_field('approval_button_3');
                            ?>
                            <a class="mButton mButton--blueButton d-block mb-3" style="width: 100%;"
                               href="<?php echo $apBtn['button_url']; ?>" target="_blank">
                                <?php echo $apBtn['button_text']; ?>
                            </a>

                            <a class="mButton mButton--blueButton d-block mb-3" style="width: 100%;"
                               href="<?php echo $apBtn2['button_url']; ?>" target="_blank">
                                <?php echo $apBtn2['button_text']; ?>
                            </a>

                            <a class="mButton mButton--blueButton d-block" style="width: 100%;"
                               href="<?php echo $apBtn3['button_url']; ?>" target="_blank">
                                <?php echo $apBtn3['button_text']; ?>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- QUALITY CONTROLS -->
        <div id="quality-controls" class="feature feature--leftImage quality-controls-section d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row align-items-center">


                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Content">
                            <h3><?php echo get_field('quality_title');?></h3>
                            <p>
                                <?php echo get_field('quality_small_text'); ?>
                            </p>


                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Image">
                            <img src="<?php echo get_field('quality_image'); ?>" class="img-fluid"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="quality-controls" class="feature feature--leftImage quality-controls-section  d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Image">
                            <img src="<?php echo get_field('quality_image'); ?>" class="img-fluid"/>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="feature__Content">
                            <h3><?php echo get_field('quality_title');?></h3>
                            <p>
                                <?php echo get_field('quality_small_text'); ?>
                            </p>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
<?php
get_footer();