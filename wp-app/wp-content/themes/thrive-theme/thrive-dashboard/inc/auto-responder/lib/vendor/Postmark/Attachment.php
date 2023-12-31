<?php

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}


class Thrive_Dash_Api_Postmark_Attachment implements \JsonSerializable {

	private $name;
	private $mimeType;
	private $data;

	public static function fromRawData( $data, $attachmentName, $mimeType = null ) {
		return new Thrive_Dash_Api_Postmark_Attachment( base64_encode( $data ), $attachmentName, $mimeType );
	}

	/*
	public static function fromStream($stream, $attachmentName, $mimeType = NULL) {
	return new PostmarkAttachment($stream, $attachmentName, $mimeType);
	}
	 */
	public static function fromFile( $filePath, $attachmentName, $mimeType = null ) {
		return new Thrive_Dash_Api_Postmark_Attachment( base64_encode( file_get_contents( $filePath ) ), $attachmentName, $mimeType );
	}

	#[\ReturnTypeWillChange]
	function jsonSerialize() {

		$retval = array(
			"Name"        => $this->name,
			"Content"     => $this->data,
			"ContentType" => $this->mimeType ?: "application/octet-stream",
			"ContentId"   => $this->name,
		);

		return $retval;
	}

	private function __construct( $base64EncodedData, $attachmentName, $mimeType = "application/octet-stream" ) {
		$this->name     = $attachmentName;
		$this->data     = $base64EncodedData;
		$this->mimeType = $mimeType;
	}

}