<?php

namespace TVE\Dashboard\Automator;

use Thrive\Automator\Items\Data_Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class Woo_Product_Catalog_Visibility
 */
class Woo_Product_Catalog_Visibility extends Data_Field {
	/**
	 * Field name
	 */
	public static function get_name() {
		return 'Catalog visibility';
	}

	/**
	 * Field description
	 */
	public static function get_description() {
		return 'Filter by catalog visibility';
	}

	/**
	 * Field input placeholder
	 */
	public static function get_placeholder() {
		return '';
	}

	public static function get_dummy_value() {
		return 'visible';
	}

	public static function get_id() {
		return 'product_catalog_visibility';
	}

	public static function get_supported_filters() {
		return array( 'string_ec' );
	}

	public static function get_validators() {
		return array( 'required' );
	}

	public static function get_field_value_type() {
		return static::TYPE_STRING;
	}
}
