<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-visual-editor
 */

namespace TCB\Integrations\WooCommerce\Shortcodes\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class Recently_Viewed_Products_Title
 *
 * @package TCB\Integrations\WooCommerce\Shortcodes\Widgets
 */
class Recently_Viewed_Products_Title extends Abstract_Sub_Element {
	/**
	 * @return string
	 */
	public function name() {
		return __( 'Recently Viewed Products Title', 'thrive-cb' );
	}

	/**
	 * @return string
	 */
	public function identifier() {
		return '.widget_recently_viewed_products .widget-title';
	}
}

return new Recently_Viewed_Products_Title( 'wc-recently-viewed-products-title' );
