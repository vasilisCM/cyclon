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
				<?php if ( have_posts() ) : ?>
				<h1 class="page-title">
					<span><?php printf(( 'Search results for the term:' . "<br>" . '"%s"'), esc_html( get_search_query() )); ?></span>
				</h1>
				<p><?php printf(esc_html(_n( 'Found %d result', 'Found %d results', (int) $wp_query->found_posts)),(int) $wp_query->found_posts); ?></p>

				<?php while ( have_posts() ) : the_post(); ?>
				<?php the_title( sprintf( '<a class="search-results__link" href="%s">', esc_url( get_permalink() ) ), '</a>'); ?>

				<?php endwhile; ?>
				<?php elseif ( is_search() ) : ?>
				<h1 class="page-title"><?php esc_html_e( 'Nothing here'); ?></h1>
				<?php endif; ?>
			</div>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
