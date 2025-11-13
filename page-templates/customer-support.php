<?php
/*
 * Template Name: Customer Support
 */
get_header(); ?>
<main id="primary" class="main-content cyclon_customer_support">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="customer_ctas text-center">
                    <?php
                    $leftBtn = get_field('top_button_left');
                    $rightBtn = get_field('top_button_right');

                    if (!empty($leftBtn)): ?>
                        <a href="<?php echo esc_url($leftBtn['btn_link']); ?>" class="bigCta">
                            <?php echo $leftBtn['btn_text']; ?>
                        </a>
                    <?php endif;

                    if (!empty($rightBtn)): ?>
                        <a href="<?php echo esc_url($rightBtn['btn_link']); ?>" class="bigCta">
                            <?php echo $rightBtn['btn_text']; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <section id="commercial-services" class="marketing-giveaways">
        <h3 class="fullTitle fullTitle--transbg">
            <span><?php echo get_field('marketing_giveaway_title'); ?></span>
        </h3>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="marketing-giveaways__Image">
                        <img src="<?php echo get_field('marketing_giveaway_image'); ?>" class="img-fluid" />
                    </div>
                    <div class="marketing-giveaways__Content">
                        <?php echo get_field('marketing_giveaway_content'); ?>
                    </div>
                    <div class="marketing-giveaways__Cta text-center">
                        <?php
                        if (get_field('marketing_giveaway_button_file')): ?>
                            <a href="<?php echo get_field('marketing_giveaway_button_file'); ?>"
                                class="d-inline-block">
                                <img src="/wp-content/uploads/2022/06/Group-17623.png"
                                    class="img-fluid" />
                            </a>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="workshop-branding">
        <h3 class="fullTitle fullTitle--transbg">
            <span><?php echo __('WORKSHOP BRANDING', 'cyclon'); ?></span>
        </h3>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    $leftTab = get_field('left_tab');
                    $rightTab = get_field('right_tab');
                    ?>
                    <div class="workshopTabsWrapper">
                        <div class="workShopTabsLinks">
                            <a href="#" data-tab="1" class="active">
                                <?php echo $leftTab['title']; ?>
                            </a>
                            <a href="#" data-tab="2">
                                <?php echo $rightTab['title']; ?>
                            </a>
                        </div>

                        <div class="workshopTabsContent">

                            <div id="tab1" class="workshop-tab">
                                <img src="<?php echo $leftTab['image']; ?>" class="img-fluid" />
                                <p class="text-center">
                                    <?php echo $leftTab['content']; ?>
                                </p>
                                <div class="workshop-cta text-center">
                                    <a href="<?php echo $leftTab['button_url']; ?>" class="text-center">
                                        <img src="/wp-content/uploads/2022/06/Group-17623.png"
                                            class="img-fluid" />
                                    </a>
                                </div>
                            </div>


                            <div id="tab2" class="workshop-tab">
                                <img src="<?php echo $rightTab['image']; ?>" class="img-fluid" />
                                <p class="text-center">
                                    <?php echo $rightTab['content']; ?>
                                </p>
                                <div class="workshop-cta text-center">
                                    <a href="<?php echo $rightTab['button_url']; ?>" class="text-center">
                                        <img src="/wp-content/uploads/2022/06/Group-17623.png"
                                            class="img-fluid" />
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


    </section>
    <section id="technical-services" class="technical-services">
        <h3 class="fullTitle fullTitle--transbg">
            <span><?php echo __('Technical Services', 'cyclon'); ?></span>
        </h3>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="technical-services-image">
                        <img src="<?php echo get_field('technical_image'); ?>" class="img-fluid" />
                    </div>

                    <div class="technical-services__Content">
                        <?php echo get_field('technical_content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer();
