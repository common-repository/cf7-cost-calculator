<?php
/*
  Plugin Name: Contact Form 7 Cost Calculator
  Plugin URI: https://azmarket.net/item/contact-form-7-cost-calculator
  Description: Contact Form 7 Cost Calculator is a clean, simple quote / project price / estimation plugin which allows you to easily create price estimation contact form 7 for your WordPress site.
  Version: 1.0.0
  Author: AzMarket
  Author URI: https://azmarket.net/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define('BH_CF7_CC_PATH', plugin_dir_path( __FILE__ ));
define('BH_CF7_CC_URL', plugin_dir_url( __FILE__ ));

class BH_CF7_CC_Init {

    /**
     * Variable to hold the initialization state.
     *
     * @var  boolean
     */
    protected static $initialized = false;
    
    /**
     * Initialize functions.
     *
     * @return  void
     */

    public static function initialize() {
        // Do nothing if pluggable functions already initialized.
        if ( self::$initialized ) {
            return;
        }

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
           add_action( 'admin_notices', array( __CLASS__, 'install_cf7_cc_admin_notice') );
        }else{
            if( is_admin() ){
                include BH_CF7_CC_PATH .'inc/admin.php';
            }else{
            	include BH_CF7_CC_PATH .'inc/frontend.php';
            }
        }
        self::$initialized = true;
    }

    /**
     * Method Featured.
     *
     * @return  array
     */

    public static function install_cf7_cc_admin_notice() {?>
        <div class="error">
            <p><?php _e( 'CF7 Database plugin is not activated. Please install and activate it to use for plugin <strong>Contact Form 7 Cost Calculator</strong>.', 'cf7-cost-calculator' ); ?></p>
        </div>
        <?php    
    }
}

if( ! function_exists('bh_cf7_cc_init') ) {
    add_action('plugins_loaded', 'bh_cf7_cc_init');

    function bh_cf7_cc_init(){
        BH_CF7_CC_Init::initialize();
    }
}
