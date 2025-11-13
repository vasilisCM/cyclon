<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Thinktank
 */

get_header();

if (have_posts()):
    while (have_posts()): the_post();
        ?>

        <main id="primary" class="main-content cyclon_single_post__Wrapper">
            <div class="single-post-wrapper__Inner">
                <article class="singlePost singlePost-<?php echo get_the_ID(); ?>">
                    <div class="singlePost__ContentWrapper">
                        <h1 class="entry-title"><?php the_title();?></h1>

                        <div class="singlePost__Main">
                            <?php the_content();?>
                        </div>


                    </div>

                </article>
            </div>
        </main><!-- #main -->
    <?php endwhile; endif; ?>
<?php
get_footer();
