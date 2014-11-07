<?php
/**
 * Plugin Name: Angular.js for Gravity Forms
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Uses Angular.js to submit to Gravity Forms
 * Version: 0.0.0
 * Author: Steve Crockett
 * Author URI: https://github.com/crockett95
 * License: GPL2
 *
 * Copyright 2014 Steve Crockett <crockett95@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function ng_gravity_forms( $atts ) {
    $a = shortcode_atts( array(
        'formid' => 1,
        'template' => 'default'
    ), $atts );

    $form = GFAPI::get_form($a['formid']);
    return '<pre>' . print_r($form, true) . '</pre>';
}
add_shortcode( 'ng-gf-atts', 'ng_gravity_forms' );

function ng_gravity_ajax() {

}
add_action( 'wp_ajax_ng_gravity_post', 'ng_gravity_ajax' );
add_action( 'wp_ajax_nopriv_ng_gravity_post', 'ng_gravity_ajax' );