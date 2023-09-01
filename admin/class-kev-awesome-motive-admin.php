<?php
/**
 * Kev_Awesome_Motive_Admin class
 *
 * @package     Kev\Awesome_Motive\Admin
 * @since       1.0.0
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kev_Awesome_Motive_Admin', false ) ) {

	/**
	 * Kev_Awesome_Motive_Admin class.
	 */
	class Kev_Awesome_Motive_Admin {

		/**
		 * Class constructor.
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_post_kev_clear_table_cache', array( $this, 'clear_cache' ) );
		}

		/**
		 * Create an admin menu and page.
		 *
		 * @return void
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function admin_menu() {
			add_menu_page(
				esc_html__( 'Awesome Table', 'kev-awesome-motive' ),
				esc_html__( 'Awesome Table', 'kev-awesome-motive' ),
				'manage_options',
				'kev-awesome-table',
				array( $this, 'render_admin_page' ),
				'dashicons-editor-table',
				80
			);
		}

		/**
		 * Render admin page, get data, and renders a table.
		 *
		 * @return void
		 *
		 * @access pubic
		 * @since 1.0.0
		 */
		public function render_admin_page() {
			$data       = Kev_Awesome_Motive_Core::get_data();
			$table_data = $data->data;

			?>
			<div class="wrap" id="kev-awesome-table">
				<div id="kev-awesome-motive-header">
					<img
						class="kev-awesome-motive-logo"
						src="<?php echo esc_url( Kev_Awesome_Motive_Core::$url . 'assets/img/awesome-table.png' ); ?>"
						alt="<?php esc_html__( 'Awesome Table', 'kev-awesome-motive' ); ?>"
					>
				</div>
				<div class="kev-awesome-motive-page kev-awesome-motive-page-general kev-awesome-motive-tab-settings">
					<div class="kev-awesome-motive-page-content">
						<div class="kev-awesome-motive-setting-row kev-awesome-motive-setting-row-content kev-awesome-motive-clear section-heading" id="kev-awesome-motive-setting-row-table-heading">
							<div class="kev-awesome-motive-setting-field">
								<h2><?php esc_html__( 'The Awesome Table', 'kev-awesome-motive' ); ?></h2>
								<p class="desc"><?php esc_html__( 'Introducing the...yup, you got it, the Awesome Table!', 'kev-awesome-motive' ); ?></p>
							</div>
						</div>

						<div id="kev-awesome-motive-setting-row-license_key" class="kev-awesome-motive-setting-row kev-awesome-motive-setting-row-license_key kev-awesome-motive-clear">
							<div class="kev-awesome-motive-setting-label">
								<span><?php echo esc_html( $data->title ); ?></span>
							</div>
							<div class="kev-awesome-motive-setting-field">
								<table class="wp-list-table widefat">
									<thead>
									<tr>
										<?php foreach ( $table_data->headers as $header ) { ?>
											<th><?php echo esc_html( $header ); ?></th>
										<?php } ?>
									</tr>
									</thead>
									<tbody>
									<?php foreach ( $table_data->rows as $row_info ) { ?>
										<tr>
											<?php foreach ( $row_info as $key => $value ) { ?>
												<?php $this->render_row_info( $key, $value ); ?>
											<?php } ?>
										</tr>
									<?php } ?>
									</tbody>
									<tfoot>
									<tr>
										<?php foreach ( $table_data->headers as $header ) { ?>
											<th><?php echo esc_html( $header ); ?></th>
										<?php } ?>
									</tr>
									</tfoot>
								</table>
								<div class="tablenav bottom">
									<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
										<input type="hidden" name="action" value="kev_clear_table_cache">
										<?php wp_nonce_field( 'kev_awesome_table_admin' ); ?>
										<button
											type="submit"
											class="kev-awesome-motive-btn kev-awesome-motive-btn-md kev-awesome-motive-btn-blueish">
											<?php echo esc_html__( 'Clear cache and refresh', 'kev-awesome-motive' ); ?>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Render individual table rows.
		 *
		 * @param string $key   Kay value.
		 * @param string $value Value.
		 *
		 * @return void
		 *
		 * @access private
		 * @since 1.0.0
		 */
		private function render_row_info( string $key, string $value ) {
			if ( 'date' === $key ) {
				?>
				<td><?php echo esc_html( gmdate( 'm/d/Y', $value ) ); ?></td>
			<?php } else { ?>
				<td><?php echo esc_html( $value ); ?></td>
				<?php
			}
		}

		/**
		 * Clears the cache and redirect back to admin view.
		 *
		 * @return void
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function clear_cache() {
			if ( check_admin_referer( 'kev_awesome_table_admin' ) ) {
				Kev_Awesome_Motive_Cache::clear();
				Kev_Awesome_Motive_Notices::add( esc_html__( 'Cache cleared', 'kev-awesome-motive' ) );

				if ( isset( $_POST['_wp_http_referer'] ) ) {
					wp_safe_redirect( wp_unslash( $_POST['_wp_http_referer'] ) );
				}
			}

			exit;
		}
	}
}
