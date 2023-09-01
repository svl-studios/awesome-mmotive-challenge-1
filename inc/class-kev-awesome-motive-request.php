<?php
/**
 * Kev_Awesome_Motive_Request class.
 *
 * @package     Kev\Awesome_Motive\Request
 * @since       1.0.0
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Request', false ) ) {

	/**
	 * Kev_Awesome_Motive_Request class.
	 */
	class Kev_Awesome_Motive_Request {

		/**
		 * API URL.
		 *
		 * @var string
		 * @access private
		 */
		private $url;

		/**
		 * Kev_Awesome_Motive_Request constructor.
		 *
		 * @param string $url URL.
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct( string $url ) {
			$this->url = $url;
		}

		/**
		 * Get API data.
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function get() {
			$args = array(
				'timeout' => 120,
			);

			$response = wp_remote_get( $this->url, $args );

			if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
				return wp_remote_retrieve_body( $response );
			}

			return false;
		}
	}
}
