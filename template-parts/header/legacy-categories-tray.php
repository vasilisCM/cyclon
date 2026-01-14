<div class="legacy-categories-tray fixed">
    <div class="legacy-categories-tray__content">
        <div class="legacy-categories-tray__toggle">
            <span class="legacy-categories-tray__icon"><img src="/wp-content/uploads/2026/01/ic-side-menu-package.svg" alt="ic-package" /></span>
            <span class="text-ms bold legacy-categories-tray__title"><?php echo get_field('categories_tray_toggle', 'option'); ?></span>
            <span class="legacy-categories-tray__icon"><img src="/wp-content/uploads/2026/01/ic-side-menu-burger.svg" alt="ic-burger" /></span>

        </div>



        <div class="legacy-categories-tray__categories">
            <div class="legacy-categories-tray__close hidden-desktop">
                &times;
            </div>

            <?php if (have_rows('categories_tray_list', 'option')): ?>
                <?php while (have_rows('categories_tray_list', 'option')): the_row(); ?>
                    <a href="<?php the_sub_field('link'); ?>">
                        <div class="legacy-categories-tray__category">
                            <div class="legacy-categories-tray__category-img-container">
                                <img src="<?php the_sub_field('image'); ?>" class="" />
                            </div>
                            <div class="legacy-categories-tray__category-text-container">
                                <div class="text bold"><?php the_sub_field('heading'); ?></div>
                                <div class="text-s"><?php the_sub_field('subheading'); ?></div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</div>