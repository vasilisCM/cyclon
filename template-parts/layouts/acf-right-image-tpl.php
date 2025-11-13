<div class="feature feature--leftImage">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="feature__Content" data-aos="fade-right" data-aos-duration="1500">
                    <h3><?php echo get_sub_field('title') ?></h3>
                    <p>
                        <?php echo get_sub_field('content'); ?>
                    </p>

                    <a class="mButton mButton--blueButton"
                       href="<?php echo get_sub_field('button_1_url'); ?>">
                        <?php echo get_sub_field('button_1_text'); ?>
                    </a>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="feature__Image" data-aos="fade-up"  data-aos-duration="1500">
                    <img src="<?php echo get_sub_field('image'); ?>" class="img-fluid"/>
                </div>
            </div>
        </div>
    </div>
</div>