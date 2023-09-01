<?php
/**
 * Kev_Awesome_Motive_Ajax class.
 *
 * @package     Kev\Awesome_Motive\AJAX
 * @since       1.0.0
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Rest', false ) ) {

	/**
	 * Kev_Awesome_Motive_Ajax class.
	 */
	class Kev_Awesome_Motive_Rest {

		/**
		 * Class constructor.
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'rest_api_init', array( $this, 'register_route' ) );
		}

		/**
		 * Register REST route.
		 *
		 * @return void
		 * @access public
		 * @since 1.0.0
		 */
		public function register_route() {
			register_rest_route(
				'kev-awesome-motive/v1',
				'/table-data',
				array(
					'methods'             => 'GET',
					'permission_callback' => '__return_true', // *always set a permission callback
					'callback'            => array( $this, 'get_table_data' ),
				)
			);
		}

		/**
		 * Rest route callback that delivers data from URL.
		 *
		 * @return array|bool|stdClass
		 * @access public
		 * @since 1.0.0
		 */
		public function get_table_data() {
			if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
				$data = Kev_Awesome_Motive_Core::get_data();

				if ( false !== $data ) {
					return $this->array_cast_recursive( Kev_Awesome_Motive_Core::get_data() );
				}
			}

			return false;
		}

		/**
		 * Convert nested objects to arrays.
		 *
		 * @param array|stdClass $obj Data to convert to arrays recursively.
		 *
		 * @return array
		 * @access private
		 * @since  1.0.0
		 */
		private function array_cast_recursive( $obj ) {
			if ( is_array( $obj ) ) {
				foreach ( $obj as $key => $value ) {
					if ( is_array( $value ) ) {
						$obj[ $key ] = $this->array_cast_recursive( $value );
					}

					if ( $value instanceof stdClass ) {
						$obj[ $key ] = $this->array_cast_recursive( (array) $value );
					}
				}
			}

			if ( $obj instanceof stdClass ) {
				return $this->array_cast_recursive( (array) $obj );
			}

			return $obj;
		}
	}
}
