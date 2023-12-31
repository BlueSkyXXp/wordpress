<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}
 if ( isset( $show_textarea ) ) : ?>
	<textarea name="tve_lead_generation_code" placeholder="<?php echo esc_html__( "Insert your code here", 'thrive-dash' ) ?>"
	          class="tve_lightbox_textarea"></textarea>
	<div class="tve_clearfix">
		<a href="javascript:void(0)" class="tve_editor_button tve_editor_button_default tve_right tve_button_margin tve_click "
		   data-ctrl="function:auto_responder.dashboard"><?php echo esc_html__( "Cancel", 'thrive-dash' ) ?></a>
		<a href="javascript:void(0)"
		   class="tve_editor_button tve_editor_button_success tve_right tve_lead_generate_fields tve_click"
		   data-ctrl="function:auto_responder.generate_fields"><?php echo esc_html__( "Generate Fields", 'thrive-dash' ) ?></a>
	</div>
<?php endif ?>
<div class="tve_large_lightbox tve_lead_gen_lightbox_small">
	<?php unset( $show_textarea ) ?>
	<div id="generated_inputs_container"
	     class="tve_clearfix">
		<?php echo isset( $fields_table ) ? $fields_table : '' ?>
	</div>
	<div id="tve_lg_icon_list" style="display: none">
		<table>
			<tfoot>
			<tr>
				<td style="width: 10%;"><?php echo esc_html__( 'Choose an icon', 'thrive-dash' ) ?></td>
				<td>
					<?php $icon_click = 'function:auto_responder.choose_icon';
					$icon_hide_header = true;
					if ( function_exists( 'tve_editor_path' ) ) {
						include_once tve_editor_path( 'editor/lb_icon.php' );
					}
					?>
				</td>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php if ( ! empty( $show_reCaptcha ) ): ?>
		<?php include dirname( __FILE__ ) . '/captcha-settings.php'; ?>
	<?php endif; ?>
	<?php do_action( 'tve_tcb_delivery_connection' ); ?>
	<?php do_action( 'tve_tcb_add_form_options', $data ); ?>

</div>
