<?php

/*
 * Template Name: Thank You
 */
get_header();
?>
<div class="taxHeader">
    <main id="primary" class="site-main">

        <section class="error-404 not-found">


            <div class="page-content">

                <div class="container">
                    <h1 class="error-heading"><?php _e('Thank you for contacting Cyclon.', 'cyclon'); ?></h1>
                    <span class="error-text text-center">
                        <?php _e('We have received your message and our team will get back to you as soon as possible.', 'cyclon'); ?>
                    </span>
                    <span class="text-center">
                        <?php _e('Kind regards,', 'cyclon'); ?> <br>
                        <?php _e('The Cyclon Team', 'cyclon'); ?>
                    </span>

                    <a class="mButton mButton--trans" href="<?php echo home_url('/'); ?>">
                        <?php _e('Back to home', 'cyclon'); ?>
                    </a>
                </div>





            </div><!-- .page-content -->
        </section><!-- .error-404 -->

    </main><!-- #main -->
</div>
<?php
get_footer();
