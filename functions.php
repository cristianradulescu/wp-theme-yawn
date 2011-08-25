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
 * Custom nav menu. Adds the search bar to menu bar
 */
function yawn_wp_nav_menu_items($items) {

return $items.<<<SEARCH_FORM
  <li class="right search">
		<form method="get" class="searchform" action="http://demo.studiopress.com/amped/">
			<input type="text" value="Search" name="s" class="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}">
			<input type="submit" class="searchsubmit" value="Search">
		</form>
	</li>
SEARCH_FORM;
}
add_action('wp_nav_menu_items', 'yawn_wp_nav_menu_items');

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

/**
 * Retrieve Digg search results
 * 
 * @param strin $term
 * 
 * @return array 
 */
function yawn_digg_search($term) {
  set_include_path(get_include_path().':'.realpath(dirname(__FILE__).'/services/Services_Digg2/'));
  require_once 'Services/Digg2.php';
  
  try {
    $sd = new Services_Digg2;
    $sd->setVersion('2.0');
    $result = $sd->search->search(array(
        'query' => $term,
        'count' => 2,
        'sort' => 'digg_count-desc',
        'offset' => rand(1, 100),
            ));
  } catch (Exception $exc) {
    return array();
  }

  return $result->stories;
}