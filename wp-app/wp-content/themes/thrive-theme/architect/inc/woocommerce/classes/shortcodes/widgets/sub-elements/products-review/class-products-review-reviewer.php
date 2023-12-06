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
 * Class Products_Review_Product_Price
 *
 * @package TCB\Integrations\WooCommerce\Shortcodes\Widgets
 */
class Products_Review_Product_Price extends Abstract_Sub_Element {
	/**
	 * @return string
	 */
	public function name() {
		return __( 'Product Reviewer', 'thrive-cb' );
	}

	/**
	 * @return string
	 */
	public function identifier() {
		return '.widget_recent_reviews .reviewer';
	}

	/**
	 * @return array
	 */
	public function own_components() {
		$components                                    = parent::_components();
		$components['typography']['disabled_controls'] = [ 'TextAlign' ];

		return $components;
	}
}

return new Products_Review_Product_Price( 'wc-products-review-reviewer' );
