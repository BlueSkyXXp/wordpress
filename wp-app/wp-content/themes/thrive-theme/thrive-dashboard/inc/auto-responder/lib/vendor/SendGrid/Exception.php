<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

/**
 * An exception thrown when SendGrid does not return a 200
 */
class Thrive_Dash_Api_SendGrid_Exception extends Exception {
	
}
