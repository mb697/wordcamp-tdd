<div class="wrap">

	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<form action="options.php" method="post">

		<?php settings_fields( 'wordcamp_tdd' ); ?>

		<?php do_settings_sections( 'wordcamp_tdd' ); ?>

		<?php submit_button( 'Save Settings' ); ?>

	</form>
</div>
