<?php
/**
 * Kev_Awesome_Motive_Notices class.
 *
 * @package     Kev\Awesome_Motive\Notices
 * @since       1.0.0
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Notices', false ) ) {

	/**
	 * Kev_Awesome_Motive_Notices class.
	 */
	class Kev_Awesome_Motive_Notices {

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'display' ) );
		}

		/**
		 * Key for temporary notice storage
		 *
		 * @var string $option_key Key for temporary notice storage.
		 */
		private static $option_key = 'kev_awesome_motive_flash_notices';

		/**
		 * Temporarily add flash notice to storage
		 *
		 * @param string $notice      Message to display.
		 * @param string $type        Message type (error|success).
		 * @param bool   $dismissible Is dismissible.
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public static function add( string $notice = '', string $type = 'success', bool $dismissible = true ) {

			/**
			 * Here we return the notices saved on our option.
			 * If there are no notices, an empty array is returned.
			 */
			$notices = get_option( self::$option_key, array() );

			$dismissible_text = ( $dismissible ) ? 'is-dismissible' : '';

			/**
			 * Add new notice.
			 */
			$notices[] = array(
				'notice'      => $notice,
				'type'        => $type,
				'dismissible' => $dismissible_text,
			);

			/**
			 * Update option with the notice array.
			 */
			update_option( self::$option_key, $notices );
		}

		/**
		 * Display notice and delete it.
		 *
		 * @access public
		 * @since   1.0.0
		 */
		public static function display() {
			$notices = get_option( self::$option_key, array() );

			/**
			 * Enum through notices to be displayed and display them.
			 */
			foreach ( $notices as $notice ) {
				printf(
					'<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
					esc_html( $notice['type'] ),
					esc_html( $notice['dismissible'] ),
					esc_html( $notice['notice'] )
				);
			}

			// Now we reset our options to prevent notices being displayed forever.
			if ( ! empty( $notices ) ) {
				delete_option( self::$option_key );
			}
		}
	}
}
