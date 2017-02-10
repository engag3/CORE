<?php
/**
* Plugin Name: CORE
* Plugin URI: http://mypluginuri.com/
* Description: A brief description about your plugin.
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author:       Ξ Π G A G Ξ _ M Ξ D I A™
* Author URI:   https://www.engag3.media
* License: A "Slug" license name e.g. GPL12
*/

/**
 * Add plugin stylesheet
 */
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
function load_admin_styles() {
 wp_enqueue_style( 'core_styles', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', false, '1.0.0' );

 wp_enqueue_script( 'core_script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', true, '1.0.0' );
//  wp_enqueue_style( 'admin_css_bar', get_template_directory_uri() . '/admin-style-bar.css', false, '1.0.0' );
}


/**
 * Disable Theme and plugin editor
 */
define( 'DISALLOW_FILE_EDIT', true );

/**
 * Remove Howdy Text
 */
function change_howdy_text_toolbar($wp_admin_bar) {
  	$getgreetings = $wp_admin_bar->get_node('my-account');
  	$rpctitle = str_replace('Howdy,','',$getgreetings->title);
  	$wp_admin_bar->add_node(array("id"=>"my-account","title"=>$rpctitle));
}
add_filter('admin_bar_menu','change_howdy_text_toolbar');




/**
 * Remove wp logo
 */
function annointed_admin_bar_remove() {
  global $wp_admin_bar;

  /* Remove their stuff */
  $wp_admin_bar->remove_menu('wp-logo');
} add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);



/**
 * Remove dashboard widgets
 */
function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
} add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


/**
 * Remove custom fields metabox
 */
function remove_post_custom_fields() {
	remove_meta_box( 'postcustom' , 'post' , 'normal' );
	remove_meta_box( 'postcustom' , 'page' , 'normal' );
	remove_meta_box( 'postcustom' , 'product' , 'normal' );
	remove_meta_box( 'postcustom' , 'shop_order' , 'normal' );
	remove_meta_box( 'postcustom' , 'project' , 'normal' );
	remove_meta_box( 'postcustom' , 'gallery' , 'normal' );
	remove_meta_box( 'postcustom' , 'client' , 'normal' );
	remove_meta_box( 'postcustom' , 'job' , 'normal' );
} add_action( 'admin_menu' , 'remove_post_custom_fields' );

/**
 * Remove excerpt metabox
 */
function remove_page_excerpt_field() {
 remove_meta_box( 'postexcerpt' , 'page' , 'normal' );
 remove_meta_box( 'postexcerpt' , 'project' , 'normal' );
}
add_action( 'admin_menu' , 'remove_page_excerpt_field' );


 /**
  * REMOVE SOME DEFAULT WIDGETS
  */
 function pc_unregister_default_widgets() {
    //  unregister_widget('WP_Widget_Pages');
    //  unregister_widget('WP_Widget_Calendar');
    //  unregister_widget('WP_Widget_Archives');
    //  unregister_widget('WP_Widget_Links');
    //  unregister_widget('WP_Widget_Categories');
    //  unregister_widget('WP_Widget_RSS');
    //  unregister_widget('WP_Widget_Tag_Cloud');
 } add_action( 'widgets_init', 'pc_unregister_default_widgets', 11 );


 // Move all "advanced" metaboxes above the default editor
 add_action('edit_form_after_title', function() {
     global $post, $wp_meta_boxes;
     do_meta_boxes(get_current_screen(), 'advanced', $post);
     unset($wp_meta_boxes[get_post_type($post)]['advanced']);
 });


 function wpse33063_move_meta_box(){
     remove_meta_box( 'postimagediv', 'post', 'side' );
     add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'post', 'advanced', 'high');
 }
 add_action('do_meta_boxes', 'wpse33063_move_meta_box');

 // 
 // function fb_remove_postbox() {
 //     wp_deregister_script('postbox');
 // }
 // add_action( 'admin_init', 'fb_remove_postbox' );
