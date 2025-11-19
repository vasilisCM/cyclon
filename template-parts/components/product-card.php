<div class="product-card">
    <!-- <?php // if (get_field('vehicle_type_icon')): 
            ?>
        <img src="<?php // echo get_field('vehicle_type_icon'); 
                    ?>" class="vehicle-icon product-card__vehicle-icon" />
    <?php // endif; 
    ?> -->
    <div class="product-card__image productCard__Image">
        <?php
        $im = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if (!empty($im)): ?>
            <img src="<?php echo $im; ?>"
                class="img-fluid" />
        <?php else: ?>
            <img src="/wp-content/uploads/2022/05/1L_MAGMA-SYN-ULTRA-S-0W-20-1.png"
                class="img-fluid" />
        <?php endif; ?>
    </div>
    <div class="productCard__Content">
        <div class="text-m">
            <span>Cyclon </span>
            <?php if (get_field('range_code')): ?>
                <?php
                $terms = get_the_terms(get_the_ID(), 'cyclon_range');
                if (!empty($terms) && !is_wp_error($terms)) :
                    $term_names = wp_list_pluck($terms, 'name');
                ?>
                    <?php echo esc_html(implode(', ', $term_names)); ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="heading-m product-card__title"><?php the_title(); ?></div>
        <?php if (get_field('range_code')): ?>
            <div class="heading-m product-card__range-code"><?php echo get_field('range_code'); ?></div>
        <?php endif; ?>
        <?php if (get_field('small_text_line')): ?>
            <div class="text-xs info product-card__info"><?php echo get_field('small_text_line'); ?></div>
        <?php endif; ?>

    </div>
    <a href="<?php the_permalink(); ?>" class="product-card__link productCard__Link"></a>
</div>