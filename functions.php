<?php
/**
 * Yawn functions and definitions
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * @package WordPress
 * @subpackage Yawn
 */


/**
 * Register widgetized areas
 *
 * @uses register_sidebar
 */
function yawn_widgets_init() {
	// Header, located at the top of the page.
	register_sidebar( array(
		'name' => __( 'Header Widget Area', 'twentyten' ),
		'id' => 'header-widget-area',
		'description' => __( 'The header widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span style="display:none;">',
		'after_title' => '</span>',
	) );
}
/** Register sidebars by running yawn_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'yawn_widgets_init' );

