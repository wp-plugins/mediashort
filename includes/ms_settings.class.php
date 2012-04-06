<?php

$ms_settings = new MediaShort_Settings();

/**
 * Options page , class
 */
class MediaShort_Settings{

    public function __construct()
    {
        add_action('admin_menu', array( &$this, 'menu' ));
    }
    
    public function menu()
    {
        global $current_user;
        add_options_page('mediashort_options', 'MediaShort', 'manage_options', 'mediashort_options', array( &$this, 'display' ));
    }

    public function display() {

        // GLOBALS
        global $wpdb;

        if ($_REQUEST['page'] != 'mediashort_options') return;

        ?>

        <div class="wrap">

            <div id="icon-plugins" class="icon32"><br/></div>

            <h2><?php _e("MediaShort Settings","mediashort"); ?></h2>

            <p class="top-notice"><?php _e('Set tag URL and activate MediaShort. ','mediashort'); ?></p>

        <?php


        $mediashort_settings = get_option( 'mediashort-settings', '');

        if ( isset( $_REQUEST['mediashort-update-settings'] ) )
        {
            if ($_REQUEST['active']) $mediashort_settings['active'] = 1;
            else $mediashort_settings['active'] = 0;

            if ($_REQUEST['remove_www']) $mediashort_settings['remove_www'] = 1;
            else $mediashort_settings['remove_www'] = 0;

            $mediashort_settings['tag'] = esc_attr($_REQUEST['tag']);

            update_option('mediashort-settings', $mediashort_settings);

            global $wp_rewrite;
            $wp_rewrite->flush_rules();

            ?>
            <div class="updated"><p><strong><?php _e("MediaShort settings is updated!","mediashort") ?></strong></p></div>
            <?php

        }

        $active = (int)$mediashort_settings['active'];
        $remove_www = (int)$mediashort_settings['remove_www'];
        $tag = empty($mediashort_settings['tag']) ? 'ms' : $mediashort_settings['tag'];

    ?>
            <form method="post" >
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Is active', 'mediashort'); ?>:</th>
                        <td>
                            <?php
                                echo '<input type="checkbox" name="active" ';
                                if ($active) echo ' checked';
                                echo '>';
                            ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Remove www from url', 'mediashort'); ?>:</th>
                        <td>
                            <?php
                                echo '<input type="checkbox" name="remove_www" ';
                                if ($remove_www) echo ' checked';
                                echo '>';
                            ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Short URL tag', 'mediashort'); ?></th>
                        <td>
                            <input type="input" name="tag" value="<?php echo $tag; ?>" /> <?php _e('(This will change the old MediaShort URLs!)','mediashort') ?>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'mediashort') ?>" />
                    <input type="hidden" name="mediashort-update-settings" value="true" />
                </p>

            </form>

        </div>

    <?php
    }
}
?>