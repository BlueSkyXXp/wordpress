<?PHP

namespace Mailgun\Messages;

/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}


use Mailgun\Constants\Api;
use Mailgun\Constants\Thrive_Dash_Api_Mailgun_ExceptionMessages;
use Mailgun\Messages\Exceptions\InvalidParameter;
use Mailgun\Messages\Exceptions\TooManyParameters;

/**
 * This class is used for composing a properly formed
 * message object. Dealing with arrays can be cumbersome,
 * this class makes the process easier. See the official
 * documentation (link below) for usage instructions.
 *
 * @link https://github.com/mailgun/mailgun-php/blob/master/src/Mailgun/Messages/README.md
 */
class MessageBuilder {
	/**
	 * @var array
	 */
	protected $message = array();

	/**
	 * @var array
	 */
	protected $variables = array();

	/**
	 * @var array
	 */
	protected $files = array();

	/**
	 * @var array
	 */
	protected $counters = array(
		'recipients' => array(
			'to'  => 0,
			'cc'  => 0,
			'bcc' => 0
		),
		'attributes' => array(
			'attachment'    => 0,
			'campaign_id'   => 0,
			'custom_option' => 0,
			'tag'           => 0
		)
	);

	/**
	 * @param array $params
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	protected function safeGet( $params, $key, $default ) {
		if ( array_key_exists( $key, $params ) ) {
			return $params[ $key ];
		}

		return $default;
	}

	/**
	 * @param array $params
	 *
	 * @return mixed|string
	 */
	protected function getFullName( $params ) {
		if ( array_key_exists( "first", $params ) ) {
			$first = $this->safeGet( $params, "first", "" );
			$last  = $this->safeGet( $params, "last", "" );

			return trim( "$first $last" );
		}

		return $this->safeGet( $params, "full_name", "" );
	}

	/**
	 * @param string $address
	 * @param array $variables
	 *
	 * @return string
	 */
	protected function parseAddress( $address, $variables ) {
		if ( ! is_array( $variables ) ) {
			return $address;
		}
		$fullName = $this->getFullName( $variables );
		if ( $fullName != null ) {
			return "'$fullName' <$address>";
		}

		return $address;
	}

	/**
	 * @param string $headerName
	 * @param string $address
	 * @param array $variables
	 */
	protected function addRecipient( $headerName, $address, $variables ) {
		$compiledAddress = $this->parseAddress( $address, $variables );

		if ( isset( $this->message[ $headerName ] ) ) {
			array_push( $this->message[ $headerName ], $compiledAddress );
		} elseif ( $headerName == "h:reply-to" ) {
			$this->message[ $headerName ] = $compiledAddress;
		} else {
			$this->message[ $headerName ] = array( $compiledAddress );
		}
		if ( array_key_exists( $headerName, $this->counters['recipients'] ) ) {
			$this->counters['recipients'][ $headerName ] += 1;
		}
	}

	/**
	 * @param string $address
	 * @param array|null $variables
	 *
	 * @return mixed
	 * @throws TooManyParameters
	 */
	public function addToRecipient( $address, $variables = null ) {
		if ( $this->counters['recipients']['to'] > Api::RECIPIENT_COUNT_LIMIT ) {
			throw new TooManyParameters( Thrive_Dash_Api_Mailgun_ExceptionMessages::TOO_MANY_PARAMETERS_RECIPIENT );
		}
		$this->addRecipient( "to", $address, $variables );

		return end( $this->message['to'] );
	}

	/**
	 * @param string $address
	 * @param array|null $variables
	 *
	 * @return mixed
	 * @throws TooManyParameters
	 */
	public function addCcRecipient( $address, $variables = null ) {
		if ( $this->counters['recipients']['cc'] > Api::RECIPIENT_COUNT_LIMIT ) {
			throw new TooManyParameters( Thrive_Dash_Api_Mailgun_ExceptionMessages::TOO_MANY_PARAMETERS_RECIPIENT );
		}
		$this->addRecipient( "cc", $address, $variables );

		return end( $this->message['cc'] );
	}

	/**
	 * @param string $address
	 * @param array|null $variables
	 *
	 * @return mixed
	 * @throws TooManyParameters
	 */
	public function addBccRecipient( $address, $variables = null ) {
		if ( $this->counters['recipients']['bcc'] > Api::RECIPIENT_COUNT_LIMIT ) {
			throw new TooManyParameters( Thrive_Dash_Api_Mailgun_ExceptionMessages::TOO_MANY_PARAMETERS_RECIPIENT );
		}
		$this->addRecipient( "bcc", $address, $variables );

		return end( $this->message['bcc'] );
	}

	/**
	 * @param string $address
	 * @param array|null $variables
	 *
	 * @return mixed
	 */
	public function setFromAddress( $address, $variables = null ) {
		$this->addRecipient( "from", $address, $variables );

		return $this->message['from'];
	}

	/**
	 * @param string $address
	 * @param array|null $variables
	 *
	 * @return mixed
	 */
	public function setReplyToAddress( $address, $variables = null ) {
		$this->addRecipient( "h:reply-to", $address, $variables );

		return $this->message['h:reply-to'];
	}

	/**
	 * @param string $subject
	 *
	 * @return mixed
	 */
	public function setSubject( $subject = "" ) {
		if ( $subject == null || $subject == "" ) {
			$subject = " ";
		}
		$this->message['subject'] = $subject;

		return $this->message['subject'];
	}

	/**
	 * @param string $headerName
	 * @param mixed $headerData
	 *
	 * @return mixed
	 */
	public function addCustomHeader( $headerName, $headerData ) {
		if ( ! preg_match( "/^h:/i", $headerName ) ) {
			$headerName = "h:" . $headerName;
		}
		$this->message[ $headerName ] = array( $headerData );

		return $this->message[ $headerName ];
	}

	/**
	 * @param string $textBody
	 *
	 * @return string
	 */
	public function setTextBody( $textBody ) {
		if ( $textBody == null || $textBody == "" ) {
			$textBody = " ";
		}
		$this->message['text'] = $textBody;

		return $this->message['text'];
	}

	/**
	 * @param string $htmlBody
	 *
	 * @return string
	 */
	public function setHtmlBody( $htmlBody ) {
		if ( $htmlBody == null || $htmlBody == "" ) {
			$htmlBody = " ";
		}
		$this->message['html'] = $htmlBody;

		return $this->message['html'];
	}

	/**
	 * @param string $attachmentPath
	 * @param string|null $attachmentName
	 *
	 * @return bool
	 */
	public function addAttachment( $attachmentPath, $attachmentName = null ) {
		if ( isset( $this->files["attachment"] ) ) {
			$attachment = array(
				'filePath'   => $attachmentPath,
				'remoteName' => $attachmentName
			);
			array_push( $this->files["attachment"], $attachment );
		} else {
			$this->files["attachment"] = array(
				array(
					'filePath'   => $attachmentPath,
					'remoteName' => $attachmentName
				)
			);
		}

		return true;
	}

	/**
	 * @param string $inlineImagePath
	 * @param string|null $inlineImageName
	 *
	 * @throws InvalidParameter
	 */
	public function addInlineImage( $inlineImagePath, $inlineImageName = null ) {
		if ( preg_match( "/^@/", $inlineImagePath ) ) {
			if ( isset( $this->files['inline'] ) ) {
				$inlineAttachment = array(
					'filePath'   => $inlineImagePath,
					'remoteName' => $inlineImageName
				);
				array_push( $this->files['inline'], $inlineAttachment );
			} else {
				$this->files['inline'] = array(
					array(
						'filePath'   => $inlineImagePath,
						'remoteName' => $inlineImageName
					)
				);
			}

			return true;
		} else {
			throw new InvalidParameter( Thrive_Dash_Api_Mailgun_ExceptionMessages::INVALID_PARAMETER_INLINE );
		}
	}

	/**
	 * @param boolean $testMode
	 *
	 * @return string
	 */
	public function setTestMode( $testMode ) {
		if ( filter_var( $testMode, FILTER_VALIDATE_BOOLEAN ) ) {
			$testMode = "yes";
		} else {
			$testMode = "no";
		}
		$this->message['o:testmode'] = $testMode;

		return $this->message['o:testmode'];
	}

	/**
	 * @param string|int $campaignId
	 *
	 * @return string|int
	 * @throws TooManyParameters
	 */
	public function addCampaignId( $campaignId ) {
		if ( $this->counters['attributes']['campaign_id'] < Api::CAMPAIGN_ID_LIMIT ) {
			if ( isset( $this->message['o:campaign'] ) ) {
				array_push( $this->message['o:campaign'], $campaignId );
			} else {
				$this->message['o:campaign'] = array( $campaignId );
			}
			$this->counters['attributes']['campaign_id'] += 1;

			return $this->message['o:campaign'];
		} else {
			throw new TooManyParameters( Thrive_Dash_Api_Mailgun_ExceptionMessages::TOO_MANY_PARAMETERS_CAMPAIGNS );
		}
	}

	/**
	 * @param string $tag
	 *
	 * @throws TooManyParameters
	 */
	public function addTag( $tag ) {
		if ( $this->counters['attributes']['tag'] < Api::TAG_LIMIT ) {
			if ( isset( $this->message['o:tag'] ) ) {
				array_push( $this->message['o:tag'], $tag );
			} else {
				$this->message['o:tag'] = array( $tag );
			}
			$this->counters['attributes']['tag'] += 1;

			return $this->message['o:tag'];
		} else {
			throw new TooManyParameters( Thrive_Dash_Api_Mailgun_ExceptionMessages::TOO_MANY_PARAMETERS_TAGS );
		}
	}

	/**
	 * @param boolean $enabled
	 *
	 * @return mixed
	 */
	public function setDkim( $enabled ) {
		if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) ) {
			$enabled = "yes";
		} else {
			$enabled = "no";
		}
		$this->message["o:dkim"] = $enabled;

		return $this->message["o:dkim"];
	}

	/**
	 * @param boolean $enabled
	 *
	 * @return string
	 */
	public function setOpenTracking( $enabled ) {
		if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) ) {
			$enabled = "yes";
		} else {
			$enabled = "no";
		}
		$this->message['o:tracking-opens'] = $enabled;

		return $this->message['o:tracking-opens'];
	}

	/**
	 * @param boolean $enabled
	 *
	 * @return string
	 */
	public function setClickTracking( $enabled ) {
		if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) ) {
			$enabled = "yes";
		} elseif ( $enabled == "html" ) {
			$enabled = "html";
		} else {
			$enabled = "no";
		}
		$this->message['o:tracking-clicks'] = $enabled;

		return $this->message['o:tracking-clicks'];
	}

	/**
	 * @param string $timeDate
	 * @param string|null $timeZone
	 *
	 * @return string
	 */
	public function setDeliveryTime( $timeDate, $timeZone = null ) {
		if ( isset( $timeZone ) ) {
			$timeZoneObj = new \DateTimeZone( "$timeZone" );
		} else {
			$timeZoneObj = new \DateTimeZone( Api::DEFAULT_TIME_ZONE );
		}

		$dateTimeObj                     = new \DateTime( $timeDate, $timeZoneObj );
		$formattedTimeDate               = $dateTimeObj->format( \DateTime::RFC2822 );
		$this->message['o:deliverytime'] = $formattedTimeDate;

		return $this->message['o:deliverytime'];
	}

	/**
	 * @param string $customName
	 * @param mixed $data
	 */
	public function addCustomData( $customName, $data ) {
		$this->message[ 'v:' . $customName ] = json_encode( $data );
	}

	/**
	 * @param string $parameterName
	 * @param mixed $data
	 *
	 * @return mixed
	 */
	public function addCustomParameter( $parameterName, $data ) {
		if ( isset( $this->message[ $parameterName ] ) ) {
			array_push( $this->message[ $parameterName ], $data );

			return $this->message[ $parameterName ];
		} else {
			$this->message[ $parameterName ] = array( $data );

			return $this->message[ $parameterName ];
		}
	}

	/**
	 * @param array $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}

	/**
	 * @return array
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return array
	 */
	public function getFiles() {
		return $this->files;
	}
}
