<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

class Thrive_Dash_Api_SparkPost_Exception extends Exception {
	/**
	 * @var string
	 */
	protected $apiMessage;

	/**
	 * @var int
	 */
	protected $apiCode;

	/**
	 * @var string
	 */
	protected $apiDescription;

	/**
	 * Construct the exception.
	 */
	public function __construct( $message = "", $code = 0, $apiMessage = "", $apiCode = 0, $apiDescription = "" ) {
		$this->apiMessage     = $apiMessage;
		$this->apiCode        = $apiCode;
		$this->apiDescription = $apiDescription;
		parent::__construct( $message, $code );
	}

	/**
	 * Gets the Exception message
	 * @return string the Exception message as a string.
	 */
	public function getAPIMessage() {
		return $this->apiMessage;
	}

	/**
	 * Gets the API Exception code.
	 * @return int the exception code as integer.
	 */
	public function getAPICode() {
		return $this->apiCode;
	}

	/**
	 * Gets the Exception description
	 * @return string the Exception description as a string.
	 */
	public function getAPIDescription() {
		return $this->apiDescription;
	}

}
