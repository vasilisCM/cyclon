<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Thinktank
 */

get_header();
?>
<div class="taxHeader">
	<main id="primary" class="site-main">

		<section class="error-404 not-found">


			<div class="page-content ">

				<span class="error-text">Error 404</span>
				<h1 class="error-heading">Page not found!</h1>
				<a class="mButton mButton--trans" href="<?php echo home_url('/'); ?>">Back to home</a>



			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
</div>
<?php
get_footer();
