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

// prevent parent theme setup
function twentyten_setup() {

}

/** Tell WordPress to run yawn_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'yawn_setup' );

function yawn_setup() {

  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  // Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

  // This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'yawn' ),
	) );

}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return void
 */
function yawn_posted_on() {
  ?>
  <span class="entry-date"><?php echo get_the_date() ?></span>
  <span class="meta-sep">|</span>
  <span class="comments-link"><?php comments_popup_link( __( 'No comments', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ) ?></span>
  <?php
}

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

	// Above content, located below the menu.
	register_sidebar( array(
		'name' => __( 'Above Content Widget Area', 'twentyten' ),
		'id' => 'above-content-widget-area',
		'description' => __( 'Above content widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span style="display:none;">',
		'after_title' => '</span>',
	) );

	// Above post
	register_sidebar( array(
		'name' => __( 'Above Post Widget Area', 'twentyten' ),
		'id' => 'above-post-widget-area',
		'description' => __( 'Above post widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span style="display:none;">',
		'after_title' => '</span>',
	) );

	// Above post content
	register_sidebar( array(
		'name' => __( 'Above Post Content Widget Area', 'twentyten' ),
		'id' => 'above-post-content-widget-area',
		'description' => __( 'Above post content widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span style="display:none;">',
		'after_title' => '</span>',
	) );

	// Below post
	register_sidebar( array(
		'name' => __( 'Below Post Widget Area', 'twentyten' ),
		'id' => 'below-post-widget-area',
		'description' => __( 'Below post widget area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span style="display:none;">',
		'after_title' => '</span>',
	) );
}
add_action('widgets_init', 'yawn_widgets_init');

/**
 * Custom nav menu. Adds the search bar to menu bar
 */
function yawn_wp_nav_menu_items($items) {
$action = get_home_url();

$value = isset($_GET['s']) ? $_GET['s'] : 'Search';
$items = $items.<<<SEARCH_FORM
  <li class="right search">
		<form method="get" class="searchform" action="{$action}">
			<input type="search" value="$value" name="s" class="s" onfocus="if (this.value == 'Search') {this.value = '';}" >
			<input type="submit" class="searchsubmit" value="Search">
		</form>
	</li>
SEARCH_FORM;

foreach (yawn_get_social_networks() as $social_network_id => $social_network_name) {
  if (get_option('yawn-show-'.$social_network_id.'-social-icon', 'no') == 'yes') {
    $linkedin_url = get_option('yawn-'.$social_network_id.'-url', '#');
    $items = $items.<<<LINKEDIN
<li class="right"><a href="$linkedin_url" class="social-icon $social_network_id" target="_blank"></a></li>
LINKEDIN;
  }
}

if (get_option('yawn-show-rss-social-icon', 'no') == 'yes') {
  $rss_url = get_feed_link();
  $items = $items.<<<RSS
<li class="right"><a href="$rss_url" class="social-icon rss"></a></li>
RSS;
}

    return $items;

}
add_action('wp_nav_menu_items', 'yawn_wp_nav_menu_items');

function yawn_get_social_networks() {
  return array(
    'linkedin' => 'LinkedIn',
    'github' => 'Github',
    'twitter' => 'Twitter',
  );
}

//add_filter('yawn_get_social_networks', $function_to_add)

/**
 * Create "Continue reading" button
 *
 * @param string $more
 * @return string
 */
function yawn_auto_excerpt_more($more) {
  remove_filter('excerpt_more', 'twentyten_auto_excerpt_more');
  $permalink = get_permalink();
  $msg = __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' );
	return '<span class="more-link-wrapper">'
          .'<a href="'.$permalink.'" class="more-link">'.$msg.'</a>'
          .'</span>';
}
add_filter('excerpt_more', 'yawn_auto_excerpt_more', 9);

/**
 * Customize excerpt
 *
 * @param string $output
 *
 * @return string
 */
function yawn_custom_excerpt_more($output) {
  remove_filter('get_the_excerpt', 'twentyten_custom_excerpt_more' );
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= yawn_auto_excerpt_more('');
	}
	return $output;
}
add_filter('get_the_excerpt', 'yawn_custom_excerpt_more', 9 );

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
function yawn_google_analytics_wp_head() {
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