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
 * @return void
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
add_action('widgets_init', 'yawn_widgets_init');

/**
 * Yawn administration menu item
 * 
 * @return void
 */
function yawn_admin_menu() {
	add_theme_page('Manage Yawn theme options', 'Yawn options', 'manage_options', 'yawn-admin', 'yawn_admin');
}
add_action('admin_menu', 'yawn_admin_menu');

/**
 * Include the administration page
 * 
 * @return void
 */
function yawn_admin() {
  require_once 'yawn-admin.php';
}

/**
 * Add Google Analytics javascript is the code was set
 * 
 * @return void
 */
function yawn_google_analytics_wp_head()
{
  if (false !== get_option('yawn-google-analitycs-code')): ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo get_option('yawn-google-analitycs-code') ?>']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
  <?php endif; 
}
add_action('wp_head', 'yawn_google_analytics_wp_head');