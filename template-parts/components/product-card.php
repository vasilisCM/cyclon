<a href="<?php the_permalink(); ?>" class="primary product-card">
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
            <img src="/wp-content/uploads/2026/01/vareli_new.png"
                class="img-fluid" />
        <?php endif; ?>
    </div>
    <div class="productCard__Content">
        <div class="text-ms uppercase">
            <span>Cyclon </span>
            <?php
            $product_range = wp_get_post_terms(get_the_ID(), 'cyclon_range');
            if (!empty($product_range) && !is_wp_error($product_range)):
            ?>
                <span><?php echo $product_range[0]->name; ?> </span>
            <?php endif; ?>
        </div>
        <div class="text-l uppercase product-card__title"><?php the_title(); ?></div>


        <div>
            <?php
            $grade_terms = get_the_terms(get_the_ID(), 'cyclon_product_grade');
            if (!empty($grade_terms) && !is_wp_error($grade_terms)) {
                // Get color from cyclon_range taxonomy term
                $range_terms = get_the_terms(get_the_ID(), 'cyclon_range');
                $color_style = '';
                if (!empty($range_terms) && !is_wp_error($range_terms)) {
                    $color = get_field('color', $range_terms[0]);
                    if ($color) {
                        $color_style = ' style="color: ' . esc_attr($color) . ';"';
                    }
                }
            ?>
                <div class="text-l uppercase product-card__grade" <?php echo $color_style; ?>><?php echo $grade_terms[0]->name; ?></div>
            <?php } ?>
        </div>

        <?php if (get_field('small_text_line')): ?>
            <div class="text-sm info product-card__info"><?php echo get_field('small_text_line'); ?></div>
        <?php endif; ?>



        <?php
        $content = strip_tags(get_the_content());
        $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $short_content = implode(' ', array_slice($words, 0, 20));
        ?>
        <div class="text-sm info product-card__info">
            <?php echo esc_html($short_content); ?><?php if (count($words) > 20) echo '...'; ?>
        </div>

        <h4 class="home-categories__category-heading">
            <span></span>
        </h4>

    </div>
</a>