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

add_action( 'wp_ajax_nopriv_ng_gravity_post', 'ng_gravity_ajax' );
add_action( 'wp_ajax_ng_gravity_post', 'ng_gravity_ajax' );

$ng_gravity_test_var = false;

function ng_gravity_forms( $atts ) {
	if (!class_exists('GFAPI')) return;

    $settings = shortcode_atts( array(
        'formid' => 1,
        'template' => 'default'
    ), $atts );

    $form = GFAPI::get_form(1);

    $template = ng_gravity_load_template($form, 'bootstrap');
	ng_gravity_add_scripts();

    return $template;
}
add_shortcode( 'ng-gf-atts', 'ng_gravity_forms' );

function ng_gravity_ajax() {
	if (!class_exists('GFAPI')) {
		return ng_gravity_return_json(array('success' => false));
	}
	$form = GFAPI::get_form(1);
	$lead_id = GFAPI::add_entry(array('form_id' => 1, '1' => $_REQUEST['input_1'], 'date_created' => date('Y-m-d H:i') ));
	$lead = RGFormsModel::get_lead($lead_id);
	GFCommon::send_form_submission_notifications($form, $lead);
	echo json_encode($lead);
	die();
}
add_action( 'wp_ajax_nopriv_ng_gravity_post', 'ng_gravity_ajax' );
add_action( 'wp_ajax_ng_gravity_post', 'ng_gravity_ajax' );

function ng_gravity_return_json($response) {
	header('Content-Type: application/json');
	echo json_encode($response);
}

function ng_gravity_add_scripts() {
	$settings = array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'action' => 'ng_gravity_post'
	);
	wp_register_script( 'angular', plugins_url( 'bower_components/angular/angular.min.js', __FILE__ ), array('jquery'), '1.3.2' );
	wp_register_script( 'ng-gravity-main', plugins_url( 'js/app.js', __FILE__ ), array('angular') );
	wp_localize_script( 'ng-gravity-main', 'NG_GRAVITY_SETTINGS', $settings );
	wp_enqueue_script( 'ng-gravity-main' );
}

function ng_gravity_load_template($form, $name = 'bootstrap') {
	$file_name = dirname(__FILE__) . "/templates/$name.php";
	$file_contents = '';

	if (file_exists($file_name)) {
		ob_start();
		include $file_name;
		$file_contents = ob_get_clean();
	}
	return $file_contents;
}