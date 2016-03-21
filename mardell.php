<?php
/*
Plugin Name: Mardell
Plugin URI: http://www.pluginuri.com
Description: Mardell
Version: 1.0
Author: Neil Carlo Sucuangco
Author URI: http://www.authoruri.com
*/

if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

define( 'TAXONOMY_SLUG' , 'mardell-map-tax' );
define( 'PLUGIN_NAME' , 'mardell' );

function mardell_theme_name_scripts()
{
	wp_enqueue_style( PLUGIN_NAME . '_custom_css' , plugins_url( 'assets/css/styles.css' , __FILE__ ) );
	wp_enqueue_script( PLUGIN_NAME . '_custom_script' , plugins_url( 'assets/js/script.js' , __FILE__ ) , array('jquery') , false , true );
	wp_enqueue_script( 'rockhill_script' , 'http://mattstow.com/js/ios-orientationchange-fix.min.js' , array() , false , true );
	wp_enqueue_script( PLUGIN_NAME . '_script_2' , plugins_url( 'assets/js/maphighlight.js' , __FILE__ ) , array('jquery') , false , true );
	wp_enqueue_script( PLUGIN_NAME . '_script_3' , plugins_url( 'assets/js/rwdImageMaps.js' , __FILE__ ) , array('jquery') , false , true );
}
add_action( 'wp_enqueue_scripts' , PLUGIN_NAME . '_theme_name_scripts' );

function mardell_showmap()
{
	require_once( dirname(__FILE__) . "/views/showmap.php" );
}
add_shortcode( 'mardell_showmap' , 'mardell_showmap' );


function pa_ajax_action()
{
	if (isset($_POST['postid']))
	{
		global $wpdb;
		$term_id = $_POST['postid'];

		$term = get_term( $term_id, TAXONOMY_SLUG );

		$args = array(
		'post_type' => 'post',
		'orderby' => 'name' ,
		'order' => 'asc' , 
		'tax_query' => array(
		    array(
		    'taxonomy' => TAXONOMY_SLUG,
		    'field' => 'id',
		    'terms' => $term_id
		     )
		  )
		);
		$query = new WP_Query( $args );

		$title = [];
		$content = [];
		$count = count($query->posts);
		foreach ($query->posts as $post)
		{
			$title[] = $post->post_title;
			$content[] = $post->post_content;
		}

		wp_send_json(array('success' => true , 'catname' => $term->name , 'title' => $title , 'content' => $content , 'count' => $count));

	}
}
add_action( 'wp_ajax_ajax_action' , 'pa_ajax_action' );
add_action( 'wp_ajax_nopriv_ajax_action' , 'pa_ajax_action' );