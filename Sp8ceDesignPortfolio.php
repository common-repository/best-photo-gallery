<?php
/*
Plugin Name: Sp8ce Design Portfolio Photo Gallery
Plugin URI: https://sp8ce.design
Version: 1.13.1
Author: Sp8ce.Design
Description: Provides shortcodes to add Sp8ce Design Portfolio grids to WordPress pages and posts
*/
add_shortcode('sp8ce-portfolio', 'sp8ce_portfolio_shortcode');

function sp8ce_portfolio_shortcode($attributes) {
    
    $attributes = shortcode_atts( array(
        'username' => false,
		'theme' => 'graham',
    ), $attributes, 'sp8ce-portfolio');
    
    if (empty($attributes['username'])) {
        // No username specified, that's no good.
        return;
    }
	
	wp_enqueue_script('prettyphoto-js', plugin_dir_url(__FILE__) . 'sp8ce/js/jquery.prettyPhoto.js', ['jquery']);
	wp_enqueue_style('prettyphoto-css', plugin_dir_url(__FILE__) . 'sp8ce/css/prettyPhoto.css');
	wp_enqueue_script('sp8ce-portfolio-js', plugin_dir_url(__FILE__) . 'sp8ce/portfolio.js', ['prettyphoto-js', 'jquery']);
	wp_enqueue_style('sp8ce-portfolio-base-css', plugin_dir_url(__FILE__) . 'sp8ce/portfolio.css'); 
	wp_enqueue_style('font-awesome-css', plugin_dir_url(__FILE__) . 'sp8ce/font-awesome/css/font-awesome.min.css');
	
	switch ($attributes['theme']) {
		default:
		case 'default':
		case 'graham':
			wp_enqueue_style('raleway-gfont', 'https://fonts.googleapis.com/css?family=Raleway:600,800');
			// Add common JS files
			wp_enqueue_style('sp8ce-portfolio-theme-css', plugin_dir_url(__FILE__) . 'sp8ce/themes/graham.css'); 
				
			break;
		case 'collis':
			wp_enqueue_style('opensans-gfont', 'https://fonts.googleapis.com/css?family=Open+Sans:600,800');
			// Add common JS files
			wp_enqueue_style('sp8ce-portfolio-theme-css', plugin_dir_url(__FILE__) . 'sp8ce/themes/collis.css');
			break;
		case 'fried':
			wp_enqueue_style('opensans-gfont', 'https://fonts.googleapis.com/css?family=Open+Sans:600,800');
			// Add common JS files
			wp_enqueue_style('sp8ce-portfolio-theme-css', plugin_dir_url(__FILE__) . 'sp8ce/themes/fried.css');
			break;
	}
    
	$showPoweredBy = (get_option('sp8ce_show_poweredby', true) == 1 ? true : false);
	$showCategories = (get_option('sp8ce_show_categories', false) == 1 ? 'true' : 'false');
	
	$html = '<div class="sp8ce-portfolio" data-username="%s" data-show-categories="%s"><div class="content"></div>';
	
	if ($showPoweredBy) {
		$html .= '<p class="sp8ce-powered-by"><a href="http://sp8ce.design/photo-gallery-plugin/">Portfolio powered by Sp8ce.Design</a></p>';
	}
	
	$html .= '</div>';
	
    printf(
		$html,
		$attributes['username'],
		$showCategories
	);
}

/**
 * Add custom option to WP dashboard
 *
 */
add_action('admin_menu', function() {
	add_menu_page('Sp8ce.Design', 'Sp8ce.Design', 'manage_options', 'sp8ce-portfolio', function() {
		include_once('templates/sp8ce-portfolio-options.php');
	}, 'dashicons-hammer', 11);
});

add_action('admin_init', function() {
	register_setting('sp8ce-portfolio-settings', 'sp8ce_show_poweredby');
	register_setting('sp8ce-portfolio-settings', 'sp8ce_show_categories');
});

add_action('admin_enqueue_scripts', function() {
	wp_enqueue_style('ionicons', plugins_url('css/ionicons.min.css', __FILE__));
	wp_enqueue_style('sp8ce-design-admin-icon-colour', plugins_url('admin-style.css', __FILE__));
});