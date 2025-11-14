<div class="product-card relatedProduct productCard col-12 col-md-6">
    <?php if (get_field('vehicle_type_icon')): ?>
        <img src="<?php echo get_field('vehicle_type_icon'); ?>" class="vehicle-icon product-card__vehicle-icon" />
    <?php endif; ?>
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
        <h3 class="product-card__title"><?php the_title(); ?></h3>
        <div class="product-card__range-code"><?php echo get_field('range_code'); ?></div>
        <!--                                                    <p class="spec"><strong>SYN - SHPD PLUS </strong> / 10W - 40</p>-->
        <div class="info product-card__info"><?php echo get_field('small_text_line'); ?></div>
    </div>
    <a href="<?php the_permalink(); ?>" class="product-card__link productCard__Link"></a>
</div>