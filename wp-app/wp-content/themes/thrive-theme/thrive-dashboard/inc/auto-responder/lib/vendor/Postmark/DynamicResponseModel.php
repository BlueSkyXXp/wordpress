<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * The DynamicResponseModel class allows flexible and forgiving access to responses from the Postmark API.
 *
 * Most responses from the PostmarkClient return a DynamicResponseModel, so understanding how it works is useful.
 *
 * Essentially, you can use either object or array index notation to lookup values. The member names are case insensitive,
 * so that each of these are acceptable ways of accessing "id" on a server response, for example:
 *
 * ```
 * //Create a client instance and get server info.
 * $client = new PostmarkClient($server_token);
 * $server = $client->getServer();
 *
 * //You have many ways of accessing the same members:
 * $server->id;
 * $server->Id;
 * $server["id"];
 * $server["ID"];
 * ```
 */
class Thrive_Dash_Api_Postmark_DynamicResponseModel extends Thrive_Dash_Api_Postmark_CaseInsensitiveArray {

	/**
	 * Create a new DynamicResponseModel from an associative array.
	 *
	 * @param array $data The source associative array.
	 */
	function __construct( array $data ) {
		parent::__construct( $data );
	}

	/**
	 * Infrastructure. Get an element by name.
	 *
	 * @param mixed $name Name of element to get from the dynamic response model.
	 */
	public function __get( $name ) {

		$value = $this[ $name ];

		// If there's a value and it's an array,
		// convert it to a dynamic response object, too.
		if ( $value != null && is_array( $value ) ) {
			$value = new Thrive_Dash_Api_Postmark_DynamicResponseModel( $value );
		}

		return $value;
	}

	/**
	 * Infrastructure. Allows indexer to return a DynamicResponseModel.
	 */
	public function offsetGet( $offset ) {
		$result = parent::offsetGet( $offset );
		if ( $result != null && is_array( $result ) ) {
			$result = new Thrive_Dash_Api_Postmark_DynamicResponseModel( $result );
		}

		return $result;
	}
}

?>