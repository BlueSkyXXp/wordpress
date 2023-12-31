<?php

/**
 * Created by PhpStorm.
 * User: radu
 * Date: 30.10.2014
 * Time: 09:48
 */
class TCB_Event_Trigger_Timer extends TCB_Event_Trigger_Abstract {
	/**
	 * should return the Event name
	 *
	 * @return mixed
	 */
	public function getName() {
		return __( 'Timer (duration after page load)', 'thrive-cb' );
	}

	/**
	 * render the timer settings
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function renderSettings( $data ) {
		return $this->renderTCBSettings( 'timer.php', $data );
	}

	/**
	 * trigger the event after a duration specified by the user
	 *
	 * @param $config
	 *
	 * @return string
	 */
	public function getInstanceJavascript( $event_data ) {
		$config = $event_data['config'];
		if ( empty( $config['t_delay'] ) ) {
			return '';
		}

		return 'jQuery(function () {setTimeout(function () {jQuery(document).trigger("tve-page-event-timer", ["' . $config['t_delay'] . '"])}, ' . (int) $config['t_delay'] * 1000 . ')})';
	}

	public function get_options() {
		return array(
			'label' => __( 'Timer', 'thrive-cb' ),
			'name'  => $this->getName(),
		);
	}
}
