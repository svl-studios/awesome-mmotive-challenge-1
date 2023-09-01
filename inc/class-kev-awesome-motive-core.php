<?php
/**
 * Kev_Awesome_Motive_Core main class.
 *
 * @since       1.0.0
 * @package     Kev\Awesome_Motive\Core
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Core', false ) ) {

	/**
	 * Main Kev_Awesome_Motive_Core class
	 *
	 * @since       1.0.0
	 */
	class Kev_Awesome_Motive_Core {

		/**
		 * Class instance.
		 *
		 * @var         Kev_Awesome_Motive_Core $instance The one true Kev_Awesome_Motive_Core.
		 * @access      private
		 */
		private static $instance;

		/**
		 * Plugin version.
		 *
		 * @var string
		 * @access public
		 */
		public static $version;

		/**
		 * Plugin URL.
		 *
		 * @var string
		 * @access public
		 */
		public static $url;

		/**
		 * Plugin directory.
		 *
		 * @var string
		 * @access public
		 */
		public static $dir;

		/**
		 * Base plugin directory.
		 *
		 * @var string
		 * @access public
		 */
		public static $base_dir;

		/**
		 * Data api URL.
		 *
		 * @var string $data_url Data API URL.
		 * @access private
		 */
		private static $data_url = 'https://miusage.com/v1/challenge/1/';

		/**
		 * Get active instance
		 *
		 * @return self::$instance The one true Kev_Awesome_Motive.
		 * @access public
		 * @since  1.0.0
		 */
		public static function instance(): ?Kev_Awesome_Motive_Core {
			if ( ! self::$instance ) {
				self::$instance = new self();

				self::$dir = plugin_dir_path( __DIR__ );
				self::$url = plugin_dir_url( __DIR__ );

				self::$instance->includes();
				self::$instance->hooks();
				self::$instance->load();
			}

			return self::$instance;
		}

		/**
		 * Include necessary files
		 *
		 * @return void
		 * @access private
		 * @since  1.0.0
		 */
		private function includes() {
			spl_autoload_register( array( __CLASS__, 'autoload' ) );
		}

		/**
		 * Run action and filter hooks
		 *
		 * @return      void
		 * @access      private
		 * @since       1.0.0
		 */
		private function hooks() {

			/**
			 * Gutenberg block.
			 */
			add_action( 'init', array( __CLASS__, 'init_block' ) );

			/**
			 * Styles.
			 */
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'styles' ) );
		}

		/**
		 * Load classes.
		 *
		 * @return void
		 * @access private
		 * @since  1.0.0
		 */
		private function load() {
			new Kev_Awesome_Motive_Rest();
			new Kev_Awesome_Motive_Admin();
			new Kev_Awesome_Motive_Notices();

			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				Kev_Awesome_Motive_CLI::init();
			}
		}

		/**
		 * Autoload PHP.
		 *
		 * @param string $class_name Classname.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function autoload( string $class_name ) {
			$class_name = 'class-' . strtolower( str_replace( '_', '-', $class_name ) );

			$dirs = array( 'inc', 'admin', 'cli' );

			foreach ( $dirs as $dir ) {
				$file = self::$base_dir . $dir . DIRECTORY_SEPARATOR . $class_name . '.php';

				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}
		}

		/**
		 * Registers the block using the metadata loaded from the `block.json` file.
		 * Behind the scenes, it also registers all assets, so they can be enqueued
		 * through the block editor in the corresponding context.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public static function init_block() {
			register_block_type( self::$base_dir . DIRECTORY_SEPARATOR . 'build' );
		}

		/**
		 * Enqueue admin styles.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public static function styles() {
			wp_enqueue_style(
				'kev-awesome-motive',
				self::$url . 'assets/css/kev-awesome-motive-admin.css',
				array(),
				self::$version
			);
		}

		/**
		 * Checks Kev_Awesome_Motive_Cache for existing data.
		 * If there is cached data, return it, otherwise, call the API,
		 * cache the result, and return it.
		 *
		 * @return mixed Data or false.
		 * @access public
		 * @since  1.0.0
		 */
		public static function get_data() {
			$cached = Kev_Awesome_Motive_Cache::get();

			if ( $cached ) {
				return $cached;
			}

			$request = new Kev_Awesome_Motive_Request( self::$data_url );
			if ( false !== $request->get() ) {
				$data = json_decode( $request->get() );

				/**
				 * Cache data.
				 */
				Kev_Awesome_Motive_Cache::save( $data );

				return $data;
			}

			return false;
		}
	}
}
