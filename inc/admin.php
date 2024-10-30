<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists('BH_CF7_CC_Admin') ) {

    class BH_CF7_CC_Admin{

        public function __construct() {

            $include = array('wpcf7-new', 'wpcf7');

            if( isset($_GET['page']) && in_array($_GET['page'], $include) ) {
                add_filter( 'wpcf7_editor_panels', array( &$this, 'wpcf7_editor_panels' ) );
                add_action('admin_footer', array( &$this, 'admin_footer_templates'), 100);
                add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ), 0, 0 );
            }

            add_action( 'wp_ajax_cf7cc_save_formulas', array( &$this, 'cf7cc_save_formulas') );
        }

        public function cf7cc_save_formulas() {
        	$json = array();

            $formulas = sanitize_text_field($_POST['formulas']);
            $form_id = absint($_POST['form_id']);
            $name = sanitize_text_field($_POST['name']);

            if( $form_id ) {
	            update_post_meta($form_id, '_cf7cc_' . $name, $formulas );
	            $json['complete'] = true;
            }
            
            wp_send_json($json);
            wp_die();
        }



        public function wpcf7_editor_panels( $panels ) {
            $panels["cc-settings-panel"] = array(
                    'title' => __( 'Cost Calculator Settings', 'cf7-cost-calculator' ),
                    'callback' => array( &$this, "bh_cf7cc_settings_form") );

            return $panels;
        }

        public function bh_cf7cc_settings_form( $post ) {
            include_once BH_CF7_CC_PATH . '/inc/tpl/admin-settings.php';
        }

        public function admin_footer_templates() {
            include_once BH_CF7_CC_PATH . '/inc/tpl/admin-form-tags.php';
            include_once BH_CF7_CC_PATH . '/inc/tpl/admin-popup.php';
        }

        public function admin_enqueue_scripts() {
            wp_enqueue_style("magnific-popup", BH_CF7_CC_URL . "assets/admin/magnific-popup.css", array(), '1.0', false );
            wp_enqueue_style("cf7cc-admin", BH_CF7_CC_URL . "assets/admin/admin.css", array(), '1.0', false );

            wp_enqueue_script("jquery.magnific-popup", BH_CF7_CC_URL . "assets/admin/jquery.magnific-popup.min.js", array(), '1.0', false );
            wp_enqueue_script("jquery.autosize", BH_CF7_CC_URL . "assets/admin/autosize.min.js", array(), '1.0', false );

            wp_enqueue_script("cf7cc-admin", BH_CF7_CC_URL . "assets/admin/admin.js", array(), '1.0', false );
            wp_localize_script( 'cf7cc-admin', 'cf7cc', array(
                'ajax_url' => admin_url('/admin-ajax.php'),
                'label' => array(
                    'data' => __('Tab', 'cf7-save2data-pro'),
                    'count' => __('Count', 'cf7-save2data-pro')
                )
            ));
        }
        
    }
    new BH_CF7_CC_Admin();
}
