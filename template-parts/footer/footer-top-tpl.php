<div class="container">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6">
					<div class="footer-widget-1">

						<?php if (is_active_sidebar('footer-1-top')):
							dynamic_sidebar('footer-1-top');
						endif;
						?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6">
					<div class="footer-widget-2">

						<?php if (is_active_sidebar('footer-2-top')):
							dynamic_sidebar('footer-2-top');
						endif;
						?>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="footer-widget-3">

						<?php if (is_active_sidebar('footer-3-top')):
							dynamic_sidebar('footer-3-top');
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="footer-widget-4">
						<?php if (is_active_sidebar('footer-4-top')):
							dynamic_sidebar('footer-4-top');
						endif;
						?>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-sm-12 col-xs-12">
					<div class="footer-widget-5">
						<?php if (is_active_sidebar('footer-5-top')):
							dynamic_sidebar('footer-5-top');
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
