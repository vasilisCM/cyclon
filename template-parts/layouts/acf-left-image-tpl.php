<div class="feature feature--rightImage">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="feature__Image" data-aos="fade-up" data-aos-duration="1500">
                    <img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="feature__Content" data-aos="fade-left" data-aos-duration="1500">
                    <h3><?php echo get_sub_field('title'); ?></h3>
                    <p>
                        <?php echo get_sub_field('content'); ?>
                    </p>
                    <?php if (have_rows('triboact_stats')): ?>
                        <div class="home__triboact_stats">
                            <?php while (have_rows('triboact_stats')): the_row();
                                $image = get_sub_field('image');
                            ?>
                                <div>
                                    <img src="<?php echo $image; ?>" alt="TriboAct">
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <a class="mButton mButton--blueButton mr-3 d-inline-block" style="margin-right: 15px;"
                        href="<?php echo get_sub_field('button_1_url'); ?>">
                        <?php echo get_sub_field('button_1_text'); ?>
                    </a>
                    <?php if (get_sub_field('button_2_text')): ?>
                        <a class="mButton mButton--blueButton d-inline-block"
                            href="<?php echo get_sub_field('button_2_url'); ?>">
                            <?php echo get_sub_field('button_2_text'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>