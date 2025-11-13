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
                    <div class="singlePost__Image">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                        <?php endif; ?>
                    </div>

                    <div class="singlePost__ContentWrapper">
                        <div class="singlePost__Category">
                            <?php $postTermsObg = wp_get_post_terms(get_the_ID(), 'category');
                            if (!empty($postTermsObg)):
                                foreach ($postTermsObg as $tobj): ?>
                                    <a href="<?php echo esc_url(get_term_link($tobj->term_id)); ?>">
                                        <?php echo $blogCatIcon = get_field('category_icon', 'category_' . $tobj->term_id); ?><?php echo $tobj->name; ?>
                                    </a>
                                <?php endforeach;
                            endif;
                            ?>
                        </div>

                        <h1 class="entry-title"><?php the_title();?></h1>
                        <div class="singlePost__Date">
                            <?php echo get_the_time(get_option('date_format')); ?>
                        </div>

                        <div class="singlePost__Main">
                            <?php the_content();?>
                        </div>

                        <a href="/news" class="backToNews">
                            <svg xmlns="http://www.w3.org/2000/svg" width="34.235" height="17.965" viewBox="0 0 34.235 17.965">
                                <g id="Group_11879" data-name="Group 11879" transform="translate(0.56 1.061)">
                                    <path id="Path_23608" data-name="Path 23608" d="M-3822.292-12978.5h-32.058" transform="translate(3855.217 12986.26)" fill="none" stroke="#042759" stroke-linecap="round" stroke-width="1.5"/>
                                    <path id="Path_23609" data-name="Path 23609" d="M-3736.728-13022.2l-7.922,7.921,7.922,7.923" transform="translate(3744.84 13022.202)" fill="none" stroke="#042759" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                </g>
                            </svg>
                            <?php echo esc_html__('BACK TO NEWS','cyclon');?>
                        </a>
                    </div>

                </article>
            </div>
        </main><!-- #main -->
    <?php endwhile; endif; ?>
<?php
get_footer();
