<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}

class Thrive_Dash_Api_GetResponseV3 {

	private $api_key;
	private $api_url = 'https://api.getresponse.com/v3';
	private $timeout = 8;
	public $http_status;
	/**
	 * X-Domain header value if empty header will be not provided
	 *
	 * @var string|null
	 */
	private $enterprise_domain = null;
	/**
	 * X-APP-ID header value if empty header will be not provided
	 *
	 * @var string|null
	 */
	private $app_id = null;

	/**
	 * Set api key and optionally API endpoint
	 *
	 * @param      $api_key
	 * @param null $api_url
	 */
	public function __construct( $api_key, $api_url = null ) {
		$this->api_key = $api_key;
		if ( ! empty( $api_url ) ) {
			$this->api_url = $api_url;
		}
	}

	/**
	 * We can modify internal settings
	 *
	 * @param $key
	 * @param $value
	 */
	function __set( $key, $value ) {
		$this->{$key} = $value;
	}

	/**
	 * get account details
	 *
	 * @return mixed
	 */
	public function accounts() {
		return $this->call( 'accounts' );
	}

	/**
	 * @return mixed
	 */
	public function ping() {
		return $this->accounts();
	}

	/**
	 * Return all campaigns
	 *
	 * @return mixed
	 */
	public function getCampaigns() {
		return $this->call( 'campaigns', 'GET', array( 'perPage' => 1000 ) );
	}

	/**
	 * get single campaign
	 *
	 * @param string $campaign_id retrieved using API
	 *
	 * @return mixed
	 */
	public function getCampaign( $campaign_id ) {
		return $this->call( 'campaigns/' . $campaign_id );
	}

	/**
	 * adding campaign
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function createCampaign( $params ) {
		return $this->call( 'campaigns', 'POST', $params );
	}

	/**
	 * list all RSS newsletters
	 *
	 * @return mixed
	 */
	public function getRSSNewsletters() {
		$this->call( 'rss-newsletters', 'GET', null );
	}

	/**
	 * send one newsletter
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function sendNewsletter( $params ) {
		return $this->call( 'newsletters', 'POST', $params );
	}

	/**
	 * @param $params
	 *
	 * @return mixed
	 */
	public function sendDraftNewsletter( $params ) {
		return $this->call( 'newsletters/send-draft', 'POST', $params );
	}

	/**
	 * add single contact into your campaign
	 *
	 * @param $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function addContact( $params ) {
		return $this->call( 'contacts', 'POST', $params );
	}

	/**
	 * retrieving contact by id
	 *
	 * @param string $contact_id - contact id obtained by API
	 *
	 * @return mixed
	 */
	public function getContact( $contact_id ) {
		return $this->call( 'contacts/' . $contact_id );
	}

	/**
	 * search contacts
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function searchContacts( $params = null ) {
		return $this->call( 'contacts?' . $this->setParams( $params ) );
	}

	/**
	 * retrieve segment
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getContactsSearch( $id ) {
		return $this->call( 'search-contacts/' . $id );
	}

	/**
	 * add contacts search
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function addContactsSearch( $params ) {
		return $this->call( 'search-contacts/', 'POST', $params );
	}

	/**
	 * add contacts search
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function deleteContactsSearch( $id ) {
		return $this->call( 'search-contacts/' . $id, 'DELETE' );
	}

	/**
	 * get contact activities
	 *
	 * @param $contact_id
	 *
	 * @return mixed
	 */
	public function getContactActivities( $contact_id ) {
		return $this->call( 'contacts/' . $contact_id . '/activities' );
	}

	/**
	 * retrieving contact by params
	 *
	 * @param array $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function getContacts( $params = array() ) {
		return $this->call( 'contacts?' . $this->setParams( $params ) );
	}

	/**
	 * Get contact by email
	 *
	 * @param $email
	 *
	 * @return bool|mixed
	 * @throws Exception
	 */
	public function getContactByEmail( $email ) {

		if ( empty( $email ) ) {
			return false;
		}

		$subscriber = $this->getContacts( array( 'query[email]' => $email ) );

		return ! empty( $subscriber[0] ) ? $subscriber[0] : false;
	}

	/**
	 * updating any fields of your subscriber (without email of course)
	 *
	 * @param       $contact_id
	 * @param array $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function updateContact( $contact_id, $params = array() ) {

		return $this->call( 'contacts/' . $contact_id, 'POST', $params );
	}

	/**
	 * drop single user by ID
	 *
	 * @param string $contact_id - obtained by API
	 *
	 * @return mixed
	 */
	public function deleteContact( $contact_id ) {
		return $this->call( 'contacts/' . $contact_id, 'DELETE' );
	}

	/**
	 * retrieve account custom fields
	 *
	 * @param array $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function getCustomFields( $params = array() ) {
		return $this->call( 'custom-fields?' . $this->setParams( $params ) );
	}

	/**
	 * add custom field
	 *
	 * @param $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function setCustomField( $params ) {
		return $this->call( 'custom-fields', 'POST', $params );
	}

	/**
	 * retrieve single custom field
	 *
	 * @param string $cs_id obtained by API
	 *
	 * @return mixed
	 */
	public function getCustomField( $custom_id ) {
		return $this->call( 'custom-fields/' . $custom_id, 'GET' );
	}

	/**
	 * retrieving billing information
	 *
	 * @return mixed
	 */
	public function getBillingInfo() {
		return $this->call( 'accounts/billing' );
	}

	/**
	 * get single web form
	 *
	 * @param int $w_id
	 *
	 * @return mixed
	 */
	public function getWebForm( $w_id ) {
		return $this->call( 'webforms/' . $w_id );
	}

	/**
	 * retrieve all webforms
	 *
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function getWebForms( $params = array() ) {
		return $this->call( 'webforms?' . $this->setParams( $params ) );
	}

	/**
	 * get single form
	 *
	 * @param int $form_id
	 *
	 * @return mixed
	 */
	public function getForm( $form_id ) {
		return $this->call( 'forms/' . $form_id );
	}

	/**
	 * retrieve all forms
	 *
	 * @param array $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function get_forms( $params = array() ) {
		return $this->call( 'forms?' . $this->setParams( $params ) );
	}

	/**
	 * Curl run request
	 *
	 * @param null   $api_method
	 * @param string $http_method
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	private function call( $api_method = null, $http_method = 'GET', $params = array() ) {
		if ( empty( $api_method ) ) {
			return (object) array(
				'httpStatus'      => '400',
				'code'            => '1010',
				'codeDescription' => 'Error in external resources',
				'message'         => 'Invalid api method',
			);
		}

		$url = $this->api_url . '/' . $api_method;

		$headers = array(
			'X-Auth-Token' => 'api-key ' . $this->api_key,
			'Content-Type' => 'application/json',
		);

		if ( ! empty( $this->enterprise_domain ) ) {
			$headers['X-Domain'] = $this->enterprise_domain;
		}
		$args = array(
			'timeout'   => 15,
			'headers'   => $headers,
			'sslverify' => false,
		);
		switch ( $http_method ) {
			case 'GET':
				$fn = 'tve_dash_api_remote_get';
				break;
			case 'DELETE':
				$args['method'] = 'DELETE';
				$fn             = 'tve_dash_api_remote_request';
				break;
			default:
				$fn           = 'tve_dash_api_remote_post';
				$args['body'] = json_encode( $params );
				break;
		}

		$response = $fn( $url, $args );
		$response_code = wp_remote_retrieve_response_code( $response );

		// Allowed response codes: Accepted 200 & 202 [validated & accepted]
		if ( ! in_array( (int) $response_code, array( 200, 202, 204 ), true ) ) {
			$message = wp_remote_retrieve_response_message( $response );
			throw new Thrive_Dash_Api_GetResponse_Exception( $message, $response_code );
		}

		$json = wp_remote_retrieve_body( $response );
		$body = json_decode( $json );

		return $body;
	}

	/**
	 * @param array $params
	 *
	 * @return string
	 */
	private function setParams( $params = array() ) {
		$result = array();
		if ( is_array( $params ) ) {
			foreach ( $params as $key => $value ) {
				$result[ $key ] = $value;
			}
		}

		return http_build_query( $result );
	}

	/**
	 * Update custom fields
	 *
	 * @param $contact_id
	 * @param $prepared_args
	 *
	 * @return bool|mixed
	 * @throws Exception
	 */
	public function updateCustomFields( $contact_id, $prepared_args ) {

		if ( ! $contact_id || empty( $prepared_args ) ) {
			return false;
		}

		return $this->updateContact( $contact_id, $prepared_args );
	}
}

