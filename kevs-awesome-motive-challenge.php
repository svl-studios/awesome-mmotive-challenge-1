<?php
/**
 *  Kev's Awesome Motive Challenge
 * Plugin Name:       Kev's Awesome Motive Challenge
 * Description:       Plugin showcasing the Awesome Motive challenge.
 * Requires at least: 6.1
 * Requires PHP:      7.1
 * Version:           1.0.0
 * Author:            Kev Provance
 * Author URI:        https://www.svlstudios.com
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       kev-awesome-motive
 *
 * @package           Kev\Awesome_Motive_Challenge
 * @author            Kev Provance (kprovance)
 * @link              http://www.svlstudios.com/
 */

/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Require the main plugin class.
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/class-kev-awesome-motive-core.php';

Kev_Awesome_Motive_Core::$version  = '1.0.0';
Kev_Awesome_Motive_Core::$base_dir = __DIR__ . DIRECTORY_SEPARATOR;

/**
 * Instance the main class.
 */
Kev_Awesome_Motive_Core::instance();
