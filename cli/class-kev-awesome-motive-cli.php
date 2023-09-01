<?php
/**
 * Kev_Awesome_Motive_CLI class.
 *
 * @since       1.0.0
 * @noinspection PhpUndefinedClassInspection
 *
 * @package      Kev\Awesome_Motive\CLI
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_CLI', false ) ) {

	/**
	 * Kev_Awesome_Motive_CLI class.
	 */
	class Kev_Awesome_Motive_CLI {

		/**
		 * Load commands classes.
		 */
		private static function load_commands() {
			require_once Kev_Awesome_Motive_Core::$base_dir . 'cli/class-kev-clear-cache-command.php';
		}

		/**
		 * Register commands.
		 */
		public static function init() {
			self::load_commands();

			WP_CLI::add_command( 'awesome refresh', 'ClearCache_Command' );
		}
	}
}
