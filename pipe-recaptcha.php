<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.upwork.com/fl/rayhan1
 * @since             1.0.0
 * @package           Pipe_Recaptcha
 *
 * @wordpress-plugin
 * Plugin Name:       Pipe Recaptcha
 * Plugin URI:        https://myrecorp.com/
 * Description:       This plugin will imbed an interesting pipe recaptcha in your contact form login or registration form. 
 * Version:           1.0.1
 * Author:            RAYHAN KABIR
 * Author URI:        https://www.upwork.com/fl/rayhan1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pipe-recaptcha
 * Domain Path:       /languages
 */

 if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'Pipe_Recaptcha_Version', '1.0.1' );
define( 'PR_Plugin_DIR_URL', plugin_dir_url(__FILE__) );
define( 'PR_Plugin_DIR_Path', plugin_dir_path(__FILE__) );

function rc_pipe_recaptcha_activation_hook(){
    require 'includes/pipe-recaptcha-plugin-activation.php';
    $rcPipeRecaptchaActivaor = new RcPipeRecaptchaActivator();
    $rcPipeRecaptchaActivaor->createTable();
    $rcPipeRecaptchaActivaor->createPuzzles();
}
register_activation_hook( __FILE__, 'rc_pipe_recaptcha_activation_hook' );


function rc_pipe_recaptcha_deactivation_hook(){
    require 'includes/pipe-recaptcha-plugin-deactivation.php';
    $rcPipeRecaptchaDectivaor = new RcPipeRecaptchaDectivator();
    $rcPipeRecaptchaDectivaor->removeTable();
}
register_deactivation_hook( __FILE__, 'rc_pipe_recaptcha_deactivation_hook' );


include 'includes/class-pipe-recaptcha-handler.php';
new pipeRecaptchaHandler();

include 'includes/ajaxRequests.php';
new \RcPipeRecaptcha\ajaxRequests();
