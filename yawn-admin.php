<?php
/**
 * The theme administration page
 *
 * @package WordPress
 * @subpackage Yawn
 * @author Cristian Radulescu
 */

$title = __('Yawn Dashboard');
$parent_file = 'themes.php';

// handle form submit
if (isset($_POST['submit'])) {
  // header
  update_option('yawn-show-header', isset($_POST['yawn-show-header']) ? 'yes' : 'no');

  // social icons
  update_option('yawn-show-rss-social-icon', isset($_POST['yawn-show-rss-social-icon']) ? 'yes' : 'no');
  foreach (yawn_get_social_networks() as $social_network_id => $social_network_name) {
    update_option('yawn-show-'.$social_network_id.'-social-icon', isset($_POST['yawn-show-'.$social_network_id.'-social-icon']) ? 'yes' : 'no');
    update_option('yawn-'.$social_network_id.'-url', $_POST['yawn-'.$social_network_id.'-url']);
  }

  // google analytics
  update_option('yawn-google-analitycs-code', $_POST['yawn-google-analitycs-code']);
}

?>

<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php echo esc_html( $title ); ?></h2>
  <?php if (isset($_POST['submit'])): ?>
  <div id="setting-error-settings_updated" class="updated settings-error">
    <p><strong><?php echo _e('Settings saved.') ?></strong></p>
  </div>
  <?php endif; ?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=yawn-admin">

    <table class="form-table">
      <tr valign="top">
        <th scope="col" colspan="2"><h3><?php _e('Layout') ?></h3></th>
      </tr>

      <!-- Header -->
      <tr valign="top">
        <th scope="row"><label for="yawn-show-header"><?php _e('Show header') ?></label></th>
        <td>
          <input name="yawn-show-header"
                 type="checkbox"
                 id="yawn-enable-header"
                 <?php if (get_option('yawn-show-header', 'no') == 'yes'): ?>checked="checked" <?php endif; ?> />
        </td>
      </tr>
      <!-- /Header -->

      <!-- Social icons -->
      <tr valign="top">
        <th scope="row"><label for="yawn-show-rss-social-icon"><?php _e('Show RSS icon') ?></label></th>
        <td>
          <input name="yawn-show-rss-social-icon"
                 type="checkbox"
                 id="yawn-show-rss-social-icon"
                 <?php if (get_option('yawn-show-rss-social-icon', 'no') == 'yes'): ?>checked="checked" <?php endif; ?> />
        </td>
      </tr>

      <?php foreach (yawn_get_social_networks() as $social_network_id => $social_network_name): ?>
        <tr valign="top">
          <th scope="row" ><label for="yawn-show-<?php echo $social_network_id ?>-social-icon"><?php _e('Show '.$social_network_name.' icon') ?></label></th>
          <td>
            <label class="howto" for="yawn-show-<?php echo $social_network_id ?>-url">
            <input name="yawn-show-<?php echo $social_network_id ?>-social-icon"
                   type="checkbox"
                   id="yawn-show-<?php echo $social_network_id ?>-social-icon"
                   <?php if (get_option('yawn-show-'.$social_network_id.'-social-icon', 'no') == 'yes'): ?>checked="checked" <?php endif; ?> />
            &nbsp;URL to profile page:
            <input name="yawn-<?php echo $social_network_id ?>-url"
                   type="text"
                   id="yawn-<?php echo $social_network_id ?>-url"
                   value="<?php echo get_option('yawn-'.$social_network_id.'-url') ?>"
                   class="regular-text" />
            </label>
          </td>
        </tr>
      <?php endforeach; ?>
      <!-- /Social icons -->

      <!-- Google analytics -->
      <tr valign="top">
        <th scope="col" colspan="2"><h3><?php _e('Google') ?></h3></th>
      </tr>
      <tr valign="top">
        <th scope="row"><label for="yawn-google-analitycs-code"><?php _e('Analytics code') ?></label></th>
        <td>
          <input name="yawn-google-analitycs-code"
                 type="text"
                 id="yawn-google-analitycs-code"
                 value="<?php echo get_option('yawn-google-analitycs-code') ?>"
                 class="regular-text" />
        </td>
      </tr>
      <!-- /Google analytics -->
    </table>
    <?php submit_button() ?>

  </form>

</div><!-- wrap -->