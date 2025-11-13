<div class="mega-menu" data-mega-menu="products">
    <div class="boxed centered mega-menu__container">
        <?php if (have_rows('mega_menu', 'option')): ?>
            <?php while (have_rows('mega_menu', 'option')): the_row(); ?>
                <?php
                $primary_image   = get_sub_field('image', 'option');
                $secondary_image = get_sub_field('image_2', 'option');
                $heading         = get_sub_field('heading', 'option');
                $text            = get_sub_field('text', 'option');
                ?>
                <article
                    class="mega-menu__item<?php echo 0 === $index ? ' is-active' : ''; ?>"
                    data-mega-panel="<?php echo esc_attr($index); ?>">
                    <?php if ($primary_image): ?>
                        <figure class="mega-menu-panel__media mega-menu-panel__media--primary">
                            <img src="<?php echo $primary_image; ?>" alt="<?php echo esc_attr($heading); ?>" loading="lazy">
                        </figure>
                    <?php endif; ?>
                    <div class="mega-menu-panel__content">
                        <?php if ($heading): ?>
                            <h3 class="mega-menu-panel__heading"><?php echo $heading; ?></h3>
                        <?php endif; ?>
                        <?php if ($text): ?>
                            <div class="mega-menu-panel__text">
                                <?php echo $text; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($secondary_image): ?>
                        <figure class="mega-menu-panel__media mega-menu-panel__media--secondary">
                            <img src="<?php echo $secondary_image; ?>" alt="<?php echo esc_attr($heading); ?>" loading="lazy">
                        </figure>
                    <?php endif; ?>
                </article> <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>