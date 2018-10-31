<?php
	/**
	 * Plugin Name: Ghost Comparison
	 * Description: Ghost Comparison Plugin for Gravity Forms.
	 * Author: Anthony Coffey
	 * Author URI: https://www.coffeywebdev.com
	 * Version: 0.1
	 */
	if ( ! defined( 'ABSPATH' ) )
		die("You don't have sufficient permission to access this page");

	include dirname( __FILE__ ) . '/activation.php';
	include dirname( __FILE__ ) . '/admin/admin.php';

	class GhostComparison {

		public function __construct() {
			// register activation hooks
			register_activation_hook( __FILE__, array( 'GhostComparisonActivation', 'activate' ) );
			// enqueue scripts
			add_action( 'wp_enqueue_scripts', array($this, "enqueue_scripts") );

			// GET CLASS DESCRIPTIONS BY STATE && INDUSTRY
			add_action( 'wp_ajax_get_ghost_class_descriptions', array($this,'get_class_descriptions') );
			add_action( 'wp_ajax_nopriv_get_ghost_class_descriptions', array($this,'get_class_descriptions') );
			// GET RATES BY CLASS ID AND STATE
			add_action( 'wp_ajax_get_ghost_rates', array($this,'get_rates') );
			add_action( 'wp_ajax_nopriv_get_ghost_rates', array($this,'get_rates') );

		}

		public function enqueue_scripts(){
			// include dependencies
			wp_enqueue_script('serialize-json',  plugin_dir_url(__FILE__).'lib/jquery.serializejson.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script('select2-js',  plugin_dir_url(__FILE__).'lib/select2/select2.min.js', array( 'jquery' ), null, true );
			//	wp_enqueue_style('select2-css', plugin_dir_url(__FILE__) . 'lib/select2/select2.min.css', array(), null, 'all' );

			// include core JS file
			$ghost_options = get_option('ghost_options');
			wp_register_script('ghost-comparison-core', plugin_dir_url(__FILE__) . 'js/main.js', array( 'jquery', 'serialize-json','select2-js' ), null, true );
			wp_localize_script('ghost-comparison-core', 'localized', array('ajax_url' => admin_url('admin-ajax.php'),'ghost_options' => $ghost_options) );
			wp_enqueue_script('ghost-comparison-core');
		}

		public function get_class_descriptions(){
			global $wpdb;

			$form = $_REQUEST['form'];
			$industry = $form['input_45'];
			$state = $form['input_1'];

			$table_name = $wpdb->prefix . 'ghostcomparison_class_descriptions';
			$table_data = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE state='" . $state . "' AND industry='" . $industry . "' ORDER BY description ASC", ARRAY_A);

			$class_descriptions = array();

			$class_descriptions[0] = array('id'=>'-','text'=>"Select a Class Description...");

			// if no table data, return one choice
			if(!$table_data) {
				echo json_encode( $class_descriptions );
				wp_die();
			} else {
				// otherwise return all queried class descriptions
				foreach($table_data as $class_description){
					$class_descriptions[] = array('id'=>$class_description['class_id'],'text'=>$class_description['description']);
				}
				echo json_encode($class_descriptions);
				wp_die();
			}


		}

		public function get_rates(){
			global $wpdb;

			$form = $_REQUEST['form'];
			$industry = $form['input_45'];
			$class_id = $form['input_46'];
			$state = $form['input_1'];

			$table_name = $wpdb->prefix . 'ghostcomparison_rates';
			$table_data = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE state='" . $state . "' AND class_id='" . $class_id . "'", ARRAY_A);


			if(!$table_data) {
				echo 0;
				wp_die();
			} else {
				echo json_encode($table_data);
				wp_die();
			}

		}

	}

	new GhostComparison();

	new GhostComparisonActivation();

	new GhostComparisonAdmin();

?>