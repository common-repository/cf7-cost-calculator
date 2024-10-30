<?php
if( ! class_exists('BH_CF7_CC_Frontend') ) {
    class BH_CF7_CC_Frontend{

        private $shortcode_atts = array();

        public function __construct() {
            add_action( 'wpcf7_init', array(&$this, 'wpcf7_init') );
            add_action( 'wp_enqueue_scripts', array($this, 'wpcf7_enqueue_scripts'), 1000);

        }

        public function wpcf7_init() {
            wpcf7_add_form_tag( array( 'cf7cc_checkbox', 'cf7cc_checkbox*' ),
                array(&$this, 'cf7cc_checkbox_callback'), array(
                    'name-attr' => true,
                    'selectable-values' => true,
                    'multiple-controls-container' => true
                )
            );

            wpcf7_add_form_tag( array( 'cf7cc_radio', 'cf7cc_radio*' ),
                array(&$this, 'cf7cc_radio_callback'), array(
                    'name-attr' => true,
                    'selectable-values' => true,
                    'multiple-controls-container' => true
                )
            );

            wpcf7_add_form_tag( array( 'cf7cc_dropdown', 'cf7cc_dropdown*' ),
                array(&$this, 'cf7cc_dropdown_callback'), array(
                    'name-attr' => true,
                    'selectable-values' => true,
                    'multiple-controls-container' => true
                )
            );

            wpcf7_add_form_tag( array( 'cf7cc_slider', 'cf7cc_slider*' ),
                array(&$this, 'cf7cc_slider_callback'), array(
                    'name-attr' => true,
                    'selectable-values' => true,
                    'multiple-controls-container' => true
                )
            );

            wpcf7_add_form_tag( array( 'cf7cc_calculated', 'cf7cc_calculated*' ),
                array(&$this, 'cf7cc_calculated_callback'), array(
                    'name-attr' => true,
                    'selectable-values' => true,
                    'multiple-controls-container' => true
                )
            );
        }

        public function cf7cc_calculated_callback( $tag ) {
            $attr_formulas = '';
            $form = wpcf7_get_current_contact_form();

            $formulas = get_post_meta($form->id(), '_cf7cc_' . $tag->name, true );

            if($formulas) {
                $attr_formulas = $formulas;
            }

            return '<span class="cf7cc-totals cf7-calculated-name" data-formulas="' . $attr_formulas .'">$0</span>';
        }

        public function cf7cc_slider_callback( $tag ) {
            $tag = new WPCF7_FormTag( $tag );
            if ( empty( $tag->name ) ) {
                return '';
            }

            $custom_values = $tag->raw_values; 
            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( $tag->type );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $label_first = $tag->has_option( 'label_first' );
            $use_label_element = $tag->has_option( 'use_label_element' );
            $exclusive = $tag->has_option( 'exclusive' );
            $free_text = $tag->has_option( 'free_text' );

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();

            $tabindex = $tag->get_option( 'tabindex', 'int', true );

            if ( false !== $tabindex ) {
                $tabindex = absint( $tabindex );
            }

            $values = (array) $tag->values;
            $labels = (array) $tag->labels;

            if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
                $defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
            }

            $html = sprintf( '<span class="radio-row">' );
            foreach ( $values as $i => $value ) {
                $type = $tag->basetype;
                $custom_data = explode("|",$custom_values[$i]);
                $label = trim($custom_data[1]);
                $value = trim($custom_data[0]);
                $checked = false;

                $item_atts = array(
                    'type' => 'radio',
                    'id' => $atts['id'] . $i,
                    'class' => $atts['class'],
                    'name' => $tag->name,
                    'value' => $value,
                    'checked' => $checked ? 'checked' : '',
                    'tabindex' => $tabindex ? $tabindex : '' );

                $item_atts = wpcf7_format_atts( $item_atts );

                $html .= sprintf('<span class="radio-col"><input %1$s /><label class="form-check-label" for="%2$s">%3$s</label></span>', $item_atts, esc_attr($atts['id'] . $i), esc_html( $label ) );
            }
            $html .= '</span>';

            return '<div class="slider"></div>';
        }

        public function cf7cc_dropdown_callback( $tag ) {
            $tag = new WPCF7_FormTag( $tag );
            if ( empty( $tag->name ) ) {
                return '';
            }

            $custom_values = $tag->raw_values; 
            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( $tag->type );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $label_first = $tag->has_option( 'label_first' );
            $use_label_element = $tag->has_option( 'use_label_element' );
            $exclusive = $tag->has_option( 'exclusive' );
            $free_text = $tag->has_option( 'free_text' );

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();

            $tabindex = $tag->get_option( 'tabindex', 'int', true );

            if ( false !== $tabindex ) {
                $tabindex = absint( $tabindex );
            }

            $values = (array) $tag->values;
            $labels = (array) $tag->labels;

            if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
                $defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
            }
            $html = sprintf( '<span class="select-row"><select id="%1$s" name="%2$s" class="%3$s" aria-invalid="false">', $atts['id'], $tag->name, 'cf7cc-fields ' . $atts['class'] );
            foreach ( $values as $i => $value ) {
                $type = $tag->basetype;
                $custom_data = explode("|",$custom_values[$i]);
                $label = trim($custom_data[1]);
                $value = trim($custom_data[0]);
                $checked = false;
                $html .= sprintf('<option value="%1$s">%2$s</option>', $value, esc_html( $label ) );
            }
            $html .= '</select></span>';

            return $html;
        }

        public function cf7cc_radio_callback( $tag ) {
            $tag = new WPCF7_FormTag( $tag );
            if ( empty( $tag->name ) ) {
                return '';
            }

            $custom_values = $tag->raw_values; 
            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( $tag->type );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $label_first = $tag->has_option( 'label_first' );
            $use_label_element = $tag->has_option( 'use_label_element' );
            $exclusive = $tag->has_option( 'exclusive' );
            $free_text = $tag->has_option( 'free_text' );

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();

            $tabindex = $tag->get_option( 'tabindex', 'int', true );

            if ( false !== $tabindex ) {
                $tabindex = absint( $tabindex );
            }

            $values = (array) $tag->values;
            $labels = (array) $tag->labels;

            if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
                $defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
            }

            $html = sprintf( '<span class="radio-row">' );
            foreach ( $values as $i => $value ) {
                $type = $tag->basetype;
                $custom_data = explode("|",$custom_values[$i]);
                $label = trim($custom_data[1]);
                $value = trim($custom_data[0]);
                $checked = false;

                $item_atts = array(
                    'type' => 'radio',
                    'id' => $atts['id'] . $i,
                    'class' => 'cf7cc-fields ' . $atts['class'],
                    'name' => $tag->name,
                    'value' => $value,
                    'checked' => $checked ? 'checked' : '',
                    'tabindex' => $tabindex ? $tabindex : '' );

                $item_atts = wpcf7_format_atts( $item_atts );

                $html .= sprintf('<span class="radio-col"><input %1$s /><label class="form-check-label" for="%2$s">%3$s</label></span>', $item_atts, esc_attr($atts['id'] . $i), esc_html( $label ) );

            }
            $html .= '</span>';

            return $html;
        }

        public function cf7cc_checkbox_callback( $tag ) {
            $tag = new WPCF7_FormTag( $tag );
            if ( empty( $tag->name ) ) {
                return '';
            }

            $custom_values = $tag->raw_values; 
            $validation_error = wpcf7_get_validation_error( $tag->name );

            $class = wpcf7_form_controls_class( $tag->type );

            if ( $validation_error ) {
                $class .= ' wpcf7-not-valid';
            }

            $label_first = $tag->has_option( 'label_first' );
            $use_label_element = $tag->has_option( 'use_label_element' );
            $exclusive = $tag->has_option( 'exclusive' );
            $free_text = $tag->has_option( 'free_text' );
            $multiple = true;

            if ( 'checkbox' == $tag->basetype ) {
                $multiple = ! $exclusive;
            } else { // radio
                $exclusive = false;
            }

            if ( $exclusive ) {
                $class .= ' wpcf7-exclusive-checkbox';
            }

            $atts = array();

            $atts['class'] = $tag->get_class_option( $class );
            $atts['id'] = $tag->get_id_option();

            $tabindex = $tag->get_option( 'tabindex', 'int', true );

            if ( false !== $tabindex ) {
                $tabindex = absint( $tabindex );
            }

            $values = (array) $tag->values;
            $labels = (array) $tag->labels;

            if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
                $defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
            }

            $html = sprintf( '<span class="checkbox-row">' );
            foreach ( $values as $i => $value ) {
                $type = $tag->basetype;
                $custom_data = explode("|",$custom_values[$i]);
                $label = trim($custom_data[1]);
                $value = trim($custom_data[0]);
                $checked = false;

                $item_atts = array(
                    'type' => 'checkbox',
                    'id' => $atts['id'] . $i,
                    'class' => 'cf7cc-fields ' . $atts['class'],
                    'name' => $tag->name . ( $multiple ? '[]' : '' ),
                    'value' => $value,
                    'checked' => $checked ? 'checked' : '',
                    'tabindex' => $tabindex ? $tabindex : '' );

                $item_atts = wpcf7_format_atts( $item_atts );

                $html .= sprintf('<span class="checkbox-col"><input %1$s /><label class="form-check-label" for="%2$s">%3$s</label></span>', $item_atts, esc_attr($atts['id'] . $i), esc_html( $label ) );
            }
            $html .= '</span>';

            return $html;
        }

        public function wpcf7_enqueue_scripts() {
            wp_enqueue_style( 'cf7cc-style', BH_CF7_CC_URL . 'assets/frontend/style.css',false,'1.1','all');
            wp_enqueue_script("jquery.cf7cc", BH_CF7_CC_URL."assets/frontend/frontend.js");
        }
    }

    new BH_CF7_CC_Frontend();
}

