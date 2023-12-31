<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}
 if ( empty( $_POST['edit_custom_html'] ) ) : ?>
	<h4><?php echo esc_html__( "Connect with Service", 'thrive-dash' ) ?></h4>
	<hr class="tve_lightbox_line"/>
	<p><?php echo esc_html__( "Your sign up form is connected to a service using custom HTML form code.", 'thrive-dash' ) ?></p>
	<div class="tve-sp"></div>
	<div class="tve_clearfix">
		<a href="javascript:void(0)" class="tve_click tve_editor_button tve_editor_button_cancel tve_right tve_button_margin"
		   data-ctrl="function:auto_responder.remove_custom_html">
			<span><?php echo esc_html__( "Delete Connection", 'thrive-dash' ) ?></span>
		</a>
		&nbsp;
		<a href="javascript:void(0)" class="tve_click tve_editor_button tve_editor_button_success tve_right"
		   data-ctrl="function:auto_responder.dashboard" data-edit-custom="1">
			<span><?php echo esc_html__( "Edit HTML form code", 'thrive-dash' ) ?></span>
		</a>
	</div>
<?php else : ?>
	<?php	$show_textarea  = true;
	$show_reCaptcha = false;
	include dirname( __FILE__ ) . '/autoresponder-code-fields.php'; ?>
<?php endif; ?>
