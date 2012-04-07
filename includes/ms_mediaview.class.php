<?php

//Create an object instance of the class
$mediaview = new MediaShort_MediaView();

// The class it self
class MediaShort_MediaView{

    function __construct(){

        add_action('admin_init', array(&$this,'admin_init'));

    }

    function admin_init(){

        add_filter("attachment_fields_to_edit", array(&$this,'fields_to_edit'), null, 2);
        add_filter( "attachment_fields_to_save", array( &$this, 'fields_to_save'), null, 2 );

    }

    function fields_to_edit($form_fields, $post){

        $settings = new MediaShort_Settings();

        if ($settings->active){

            $root = get_bloginfo('url');

            if (!empty($settings->baseurl)) $root = $settings->baseurl;

            $url = $root . '/'.$settings->tag.'/' . $post->ID;

            $ext = "";
            $ext_start = strrpos($post->guid,'.');
            if ($ext_start>0){
                $ext = substr($post->guid, $ext_start);
            }

            if ($settings->links & 1){
                $form_fields["mediashort1"] = array(
                   "label" => __("Alternative URL 1","mediashort"),
                   "input" => "html",
                   "html" =>
                       '<input type="text" readonly="readonly" value="'.$url.'" onclick="jQuery(this).focus(); jQuery(this).select();" />'
                );
            }

            if ($settings->links & 2){
                $form_fields["mediashort2"] = array(
                   "label" => __("Alternative URL 2","mediashort"),
                   "input" => "html",
                   "html" =>
                    '<input type="text" readonly="readonly" value="'.$url . $ext.'" onclick="jQuery(this).focus(); jQuery(this).select();" />'
                );
            }

            if ($settings->links & 4){
                $form_fields["mediashort3"] = array(
                   "label" => __("Alternative URL 3","mediashort"),
                   "input" => "html",
                   "html" =>
                   '<input type="text" readonly="readonly" value="'.$url . '/' . $post->post_name.'" onclick="jQuery(this).focus(); jQuery(this).select();" />'
                );
            }

            if ($settings->links & 8){
                $form_fields["mediashort4"] = array(
                   "label" => __("Alternative URL 4","mediashort"),
                   "input" => "html",
                   "html" =>
                   '<input type="text" readonly="readonly" value="'.$url . '/' . $post->post_name . $ext.'" onclick="jQuery(this).focus(); jQuery(this).select();" />'
                );
            }

            if ($settings->transfer!="redirect"){
                $attachment = (int)get_post_meta($post->ID, '_mediashort_attachment', true) ? "checked" : "";
                $form_fields["mediashort_attachment"] = array(
                   "label" => "",
                   "input" => "html",
                   "html" =>
                       '<input type="checkbox" value="attachment" name="attachments['.$post->ID.'][mediashort_attachment]" id="attachments['.$post->ID.'][mediashort_attachment]" '.$attachment.' /> ' . __("Use MediaShort-URLs as an attachment and force browser download","mediashort")
                );
            }

        }

        return $form_fields;

    }

    function fields_to_save($post, $attachment) {
        if( isset($attachment['mediashort_attachment']) ){
            update_post_meta($post['ID'], '_mediashort_attachment', 1);
        }
        else{
            update_post_meta($post['ID'], '_mediashort_attachment', 0);
        }
        return $post;
    }

}

?>