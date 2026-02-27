<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Thinktank
 */

get_header();
?>

<main id="primary" class="site-main search-results">
	<div class="search-results__wrapper">
		<?php if (have_posts()) : ?>
			<h1 class="page-title">
				<span><?php echo __('Search results for the term:', 'cyclon'); ?><br>
					<?php printf(('"%s"'), esc_html(get_search_query())); ?></span>
			</h1>
			<p><?php printf(esc_html(_n('Found %d result', 'Found %d results', (int) $wp_query->found_posts)), (int) $wp_query->found_posts); ?></p>

			<?php while (have_posts()) : the_post(); ?>
				<?php
				if (get_post_type() === 'cyclon_new_product') {
					$product_range = wp_get_post_terms(get_the_ID(), 'cyclon_range');
					$grade_terms   = wp_get_post_terms(get_the_ID(), 'cyclon_product_grade');
					$parts         = array('');
					if (! empty($product_range) && ! is_wp_error($product_range)) {
						$parts[] = $product_range[0]->name;
					}
					if (! empty($grade_terms) && ! is_wp_error($grade_terms)) {
						$parts[] = $grade_terms[0]->name;
					}
					$parts[] = get_the_title();
					$title   = implode(' ', $parts);
					printf('<a class="search-results__link" href="%s">%s</a>', esc_url(get_permalink()), esc_html($title));
				} else {
					the_title(sprintf('<a class="search-results__link" href="%s">', esc_url(get_permalink())), '</a>');
				}
				?>

			<?php endwhile; ?>
		<?php elseif (is_search()) : ?>
			<h1 class="page-title"><?php esc_html_e('Nothing here'); ?></h1>
		<?php endif; ?>
	</div>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
