<?php
/*
 * Template Name: Booking
 */
get_header(); ?>

<main id="primary" class="main-content cyclon_blog">

    <section class="">
        <div class="technologyIntro__container">
            <div>
                <p><?php echo get_field('hero_text__booking'); ?></p>
            </div>
        </div>
    </section>

    <section class="technologyIntro">
        <div class="technologyIntro__container">
            <div>
                <?php the_content(); ?>
            </div>
        </div>
    </section>

</main>
<?php
get_footer();
