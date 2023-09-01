<?php
/**
 * Kev_Clear_Cache_Command class.
 *
 * @since       1.0.0
 * @package     Kev\Awesome_Motive\CLI\Command
 *
 * @noinspection PhpUndefinedClassInspection
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Clear_Cache_Command', false ) ) {

	/**
	 * Kev_Clear_Cache_Command class.
	 */
	class Kev_Clear_Cache_Command {

		/**
		 * Class __invoke.
		 *
		 * @return void
		 */
		public function __invoke() {
			if ( Kev_Awesome_Motive_Cache::clear() ) {
				WP_CLI::success( __( 'Data cache cleared', 'kev-awesome-motive' ) );
			} else {
				WP_CLI::warning( __( 'Unable to clear cache', 'kev-awesome-motive' ) );
			}
		}
	}
}
