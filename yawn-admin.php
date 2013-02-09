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
  <?php endif;


  var_dump(get_option('yawn-show-header'));
  ?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=yawn-admin">

    <table class="form-table">

      <!-- Header -->
      <tr valign="top">
        <th scope="col" colspan="2"><h3><?php _e('Layout') ?></h3></th>
      </tr>
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