<div class="feature feature--triboAct">
    <div class="feature--triboActbg" style="background-image:url(<?php echo get_sub_field('background_image'); ?>)"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="feature__Image">
                    <img src="<?php echo get_sub_field('image'); ?>" class="img-fluid"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="feature__Content">
                    <h3 class="mleft"><?php echo get_sub_field('title') ?></h3>
                    <div class="feature__subtitles">
                        <div><?php echo get_sub_field('first_small_text') ?></div>
                        <div><?php echo get_sub_field('second_small_text') ?></div>
                        <div><?php echo get_sub_field('third_small_text') ?></div>
                    </div>
                    <p class="mleft">
                        <?php echo get_sub_field('content'); ?>
                    </p>

                    <a class="mButton mButton--trans mleft"
                       href="<?php echo get_sub_field('button_1_url'); ?>">
                        <?php echo get_sub_field('button_1_text'); ?>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>