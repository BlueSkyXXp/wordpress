<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-theme
 */

namespace Thrive\Theme\Integrations\WooCommerce\Elements;

use Thrive\Theme\Integrations\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class Product_Review_Only_Logged_In_Text
 * @package Thrive\Theme\Integrations\WooCommerce\Elements
 */
class Product_Review_Only_Logged_In_Text extends WooCommerce\Elements\Abstract_Sub_Element {
	/**
	 * @return string
	 */
	public function name() {
		return __( 'Review Text', 'thrive-theme' );
	}

	/**
	 * @return string
	 */
	public function identifier() {
		return '#reviews .woocommerce-verification-required';
	}
}

return new Product_Review_Only_Logged_In_Text( 'wc-product-review-only-logged-in-text' );
