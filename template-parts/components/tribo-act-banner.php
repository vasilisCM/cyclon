<section class="tribo-act-banner">
    <?php $triboAct = get_field('tribo_act', 'option'); ?>
    <div class="container">
        <div class="tribo-act-banner__container">
            <div class="tribo-act-banner__logo-container">
                <div class="tribo-act-banner__logo">
                    <img src="<?php echo $triboAct['image']; ?>" alt="Tribo Act">
                </div>
                <div class="tribo-act-banner__logo-text primary">
                    <h2 class="tribo-act-banner__logo-title text-xl line-height-s">
                        <?php echo $triboAct['heading']; ?>
                    </h2>
                    <div class="tribo-act-banner__logo-moto text sans line-height-m">
                        <?php echo $triboAct['text']; ?>
                    </div>
                </div>
            </div>
            <div class="tribo-act-banner__features-container">
                <?php if (have_rows('tribo_act', 'option')) :

                    // move inside the group
                    the_row();

                    if (have_rows('features')) :
                        while (have_rows('features')) : the_row(); ?>
                            <div class="tribo-act-banner__feature">
                                <div class="tribo-act-banner__feature-number relative">
                                    <div class="sans primary line-height-s"><?php echo get_sub_field('number'); ?></div>
                                    <div class="tribo-act-banner__feature-image absolute">
                                        <img src="<?php echo get_sub_field('image'); ?>" alt="">
                                    </div>
                                </div>
                                <div class="tribo-act-banner__feature-text text primary line-height-m">
                                    <?php echo get_sub_field('text'); ?>
                                </div>
                            </div>
                <?php
                        endwhile;
                    endif;
                endif; ?>
            </div>
            <div class="tribo-act-banner__button-container">
                <a class="button-with-arrow uppercase primary" href="<?php echo $triboAct['button']['link']; ?>" target="_blank"><?php echo $triboAct['button']['label']; ?></a>
            </div>
        </div>
    </div>
</section>