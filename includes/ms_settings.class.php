<?php

$ms_settings = new MediaShort_Settings();

/**
 * Options page , class
 */
class MediaShort_Settings{

    public $active;
    public $transfer;
    public $baseurl;
    public $tag;
    public $links;

    public function __construct()
    {
        add_action('admin_menu', array( &$this, 'menu' ));
        $this->init_variables();
    }

    function init_variables(){
        $mediashort_settings = get_option( 'mediashort-settings', '');
        $this->active = (int)$mediashort_settings['active'];
        $this->transfer = empty($mediashort_settings['transfer']) ? 'file' : $mediashort_settings['transfer'];
        $this->baseurl = $mediashort_settings['baseurl'];
        $this->tag = empty($mediashort_settings['tag']) ? 'ms' : $mediashort_settings['tag'];
        $this->links = empty($mediashort_settings['links']) ? '1' : $mediashort_settings['links'];
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

            $transfer = esc_attr($_REQUEST['transfer']);
            $mediashort_settings['transfer'] = empty($transfer) ? 'file' : $transfer;
            $mediashort_settings['baseurl'] = esc_attr($_REQUEST['baseurl']);
            $mediashort_settings['tag'] = esc_attr($_REQUEST['tag']);

            $links = 0;
            foreach($_REQUEST['links'] as $link){
                $links += (int)$link;
            }
            $mediashort_settings['links'] = (int)$links;

            update_option('mediashort-settings', $mediashort_settings);

            global $wp_rewrite;
            $wp_rewrite->flush_rules();

            ?>
            <div class="updated"><p><strong><?php _e("MediaShort settings is updated!","mediashort") ?></strong></p></div>
            <?php

            $this->init_variables();
        }

            $root = get_bloginfo('url');
            if (!empty($this->baseurl)) $root = $this->baseurl;

            $filename = "example";
            $ext = ".jpg";
            $post_id = 465;

            //Get the latest attachment as an example!
            $args = array(
                'numberposts'     => 1,
                'post_type'       => 'attachment'
            );
            $posts_array = get_posts( $args );

            if (sizeof($posts_array)>0){
                $post_id = $posts_array[0]->ID;
                $post = get_post($post_id);
                $filename = $post->post_name;
                $ext_start = strrpos($post->guid,'.');
                if ($ext_start>0){
                    $ext = substr($post->guid, $ext_start);
                }
            }


    ?>
            <form method="post" >
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Is active', 'mediashort'); ?>:</th>
                        <td>
                            <?php
                                echo '<input type="checkbox" name="active" ';
                                if ($this->active) echo ' checked';
                                echo '>';
                            ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Base URL replacement', 'mediashort'); ?></th>
                        <td>
                            <input type="input" name="baseurl" value="<?php echo $this->baseurl; ?>" /> <?php _e('(In case of use duplicate url address, eg http://amek.se instead of base url http://www.amek.se)','mediashort') ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Short URL tag', 'mediashort'); ?></th>
                        <td>
                            <input type="input" name="tag" value="<?php echo $this->tag; ?>" /> <?php _e('(This will change the old MediaShort URLs!)','mediashort') ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Transfer mode', 'mediashort'); ?></th>
                        <td>
                            <input name="transfer" type="radio" value="redirect" <?php if ($this->transfer=='redirect') echo 'checked'; ?>> <?php _e('Redirect (force download as attachment will not work)','mediashort'); ?><br/>
                            <input name="transfer" type="radio" value="file" <?php if ($this->transfer=='file') echo 'checked'; ?>> <?php _e('Rewrite the url and transfer content','mediashort'); ?><br/>
                            <!--input enabled="false" name="transfer" type="radio" value="curl" <?php if ($this->transfer=='curl') echo 'checked'; ?>> <?php _e('Use cURL','mediashort'); ?><br/-->
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Show link type in media dialog', 'mediashort'); ?></th>
                        <td>
                            <input name="links[]" type="checkbox" value="1" <?php if ($this->links & 1) echo 'checked'; ?> /> <?php _e("Alternative URL 1: Shortest possible","mediashort") ?>, <?php echo $root; ?>/<?php echo $this->tag ?>/ID, eg <em><a target="_blank" href="<?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?>"><?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?></a></em><br/>
                            <input name="links[]" type="checkbox" value="2" <?php if ($this->links & 2) echo 'checked'; ?> /> <?php _e("Alternative URL 2: Short with filename extention","mediashort") ?>, <?php echo $root; ?>/<?php echo $this->tag ?>/ID.extention, eg <em><a target="_blank" href="<?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?><?php echo $ext; ?>"><?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?><?php echo $ext; ?></a></em><br/>
                            <input name="links[]" type="checkbox" value="4" <?php if ($this->links & 4) echo 'checked'; ?> /> <?php _e("Alternative URL 3: The filename","mediashort") ?>, <?php echo $root; ?>/<?php echo $this->tag ?>/ID/filename, eg <em><a target="_blank" href="<?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?>/<?php echo $filename; ?>"><?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?>/<?php echo $filename; ?></a></em><br/>
                            <input name="links[]" type="checkbox" value="8" <?php if ($this->links & 8) echo 'checked'; ?> /> <?php _e("Alternative URL 4: The filename and extention","mediashort") ?>, <?php echo $root; ?>/<?php echo $this->tag ?>/ID/filename.extention, eg <em><a target="_blank" href="<?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?>/<?php echo $filename; ?><?php echo $ext; ?>"><?php echo $root; ?>/<?php echo $this->tag; ?>/<?php echo $post_id; ?>/<?php echo $filename; ?><?php echo $ext; ?></a></em><br/>
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