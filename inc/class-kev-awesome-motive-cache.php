<?php
/**
 * Class Kev_Awesome_Motive_Cache.
 *
 * @since       1.0.0
 * @package     Kev\Awesome_Motive\Cache
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Cache', false ) ) {

	/**
	 * Kev_Awesome_Motive_Cache class.
	 */
	class Kev_Awesome_Motive_Cache {

		/**
		 * Cache key.
		 *
		 * @var string Cache key.
		 * @access private
		 */
		private static $cache_data_key = 'kev_awesome_motive_table';

		/**
		 * Cache expiration in seconds.
		 *
		 * @var int Cache expiry.
		 * @access private
		 */
		private static $cache_expiry = 3600; // One hour.

		/**
		 * Get cached data.
		 *
		 * @return mixed Cached data.
		 * @access  public
		 * @since 1.0.0
		 */
		public static function get() {
			return get_transient( self::$cache_data_key );
		}

		/**
		 * Update cached data.
		 *
		 * @param mixed $data Data to cache.
		 *
		 * @return void
		 * @access public
		 * @since 1.0.0.
		 */
		public static function save( $data ) {
			set_transient( self::$cache_data_key, $data, self::$cache_expiry );
		}

		/**
		 * Clear cached data.
		 *
		 * @return bool
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public static function clear(): bool {
			return delete_transient( self::$cache_data_key );
		}
	}
}
