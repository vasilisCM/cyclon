<div class="legacy-categories-tray fixed">
    <div class="legacy-categories-tray__content">
        <div class="legacy-categories-tray__toggle">
            <span>⛽</span>
            <span class="text-s bold legacy-categories-tray__title"><?php echo get_field('categories_tray_toggle', 'option'); ?></span>
            <span>🍔</span>

        </div>

        <div class="legacy-categories-tray__close hidden-desktop">
            &times;
        </div>

        <div class="legacy-categories-tray__categories">


            <?php if (have_rows('categories_tray_list', 'option')): ?>
                <?php while (have_rows('categories_tray_list', 'option')): the_row(); ?>
                    <div class="catBox legacy-categories-tray__category">
                        <div class="catBox__Inner">
                            <a href="<?php the_sub_field('link'); ?>">
                                <img src="<?php the_sub_field('image'); ?>" class="catBoxImage" />
                            </a>
                        </div>
                        <div class="legacy-categories-tray__category-text-container">
                            <a href="<?php the_sub_field('link'); ?>">
                                <div class="text bold"><?php the_sub_field('heading'); ?></div>
                            </a>
                            <div class="text-s"><?php the_sub_field('subheading'); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</div>