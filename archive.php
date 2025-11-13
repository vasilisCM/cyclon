<?php

get_header(); ?>
    <main id="primary" class="main-content cyclon_blog">
        <!-- Categories -->
        <div class="container">
            <div class="row">
                <?php // get all terms
                $blogCats = get_terms(array('taxonomy' => 'category', 'hide_empty' => false));
                if (!empty($blogCats)):
                    foreach ($blogCats as $bc):
                        if ($bc->term_id == 1):continue; endif;
                        ?>
                        <div class="col-mg-4 col-lg-4 col-sm-6 col-xs-12">

                            <a href="<?php echo esc_url(get_term_link($bc->term_id)); ?>" class="blogCategory__Link" data-category="<?php echo $bc->term_id;?>">
                                <?php echo $blogCatIcon = get_field('category_icon', 'category_' . $bc->term_id); ?> <?php echo $bc->name; ?>

                                <svg class="blogArrow" xmlns="http://www.w3.org/2000/svg" width="31.852" height="17.121"
                                     viewBox="0 0 31.852 17.121">
                                    <g id="Group_17058" data-name="Group 17058"
                                       transform="translate(-1321.05 -1554.851)" opacity="0.35">
                                        <path id="Path_23608" data-name="Path 23608" d="M-3854.35-12978.5H-3824"
                                              transform="translate(5176.15 14541.758)" fill="none" stroke="#fff"
                                              stroke-linecap="round" stroke-width="1.5"/>
                                        <path id="Path_23609" data-name="Path 23609"
                                              d="M-3744.65-13022.2l7.5,7.5-7.5,7.5"
                                              transform="translate(5089.152 14578.112)" fill="none" stroke="#fff"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                    </g>
                                </svg>
                            </a>


                        </div>
                    <?php endforeach;
                endif; ?>

            </div>
        </div>

        <!-- Blog Content -->
        <section class="blogWrapper">
            <div class="blogWrapper__Inner">
                <div class="container">
                    <div class="row">
                        <?php

                        if (have_posts()):
                            while (have_posts()): the_post(); ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                    <div class="blogCard">
                                        <div class="blogCard__Image">
                                            <?php if (has_post_thumbnail()):
                                                the_post_thumbnail('full', array('img-fluid'));
                                            endif; ?>
                                        </div>
                                        <div class="blogCard__Date">
                                            <?php echo get_the_time(get_option('date_format')); ?>
                                        </div>
                                        <div class="blogCard__Content">
                                            <h3><?php the_title(); ?></h3>
                                            <?php if (get_field('excerpt')): ?>
                                                <p>
                                                    <?php echo get_field('excerpt'); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                        <svg class="blogCard__ReadMoreArrow" xmlns="http://www.w3.org/2000/svg"
                                             width="39.863" height="21.08" viewBox="0 0 39.863 21.08">
                                            <g id="Group_11879" data-name="Group 11879"
                                               transform="translate(-1321.05 -1554.851)">
                                                <path id="Path_23608" data-name="Path 23608"
                                                      d="M-3854.35-12978.5h38.363"
                                                      transform="translate(5176.15 14543.697)" fill="none"
                                                      stroke="#042759" stroke-linecap="round" stroke-width="1.5"/>
                                                <path id="Path_23609" data-name="Path 23609"
                                                      d="M-3744.65-13022.2l9.479,9.479-9.479,9.48"
                                                      transform="translate(5095.144 14578.112)" fill="none"
                                                      stroke="#042759" stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="1.5"/>
                                            </g>
                                        </svg>
                                        <a href="<?php the_permalink(); ?>" class="blogCard__ReadMore"></a>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php get_footer();