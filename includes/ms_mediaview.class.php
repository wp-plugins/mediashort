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

    }

    function fields_to_edit($form_fields, $post){

        $mediashort_settings = get_option( 'mediashort-settings', '');
        $active = $mediashort_settings['active'];
        $remove_www = $mediashort_settings['remove_www'];
        $tag = empty($mediashort_settings['tag']) ? 'ms' : $mediashort_settings['tag'];

        if ($active){

            $root = get_bloginfo('url');

            if ($remove_www) $root = str_replace('www.', '', $root);

            $url = $root . '/'.$tag.'/' . $post->ID;

            $ext = "";
            $ext_start = strrpos($post->guid,'.');
            if ($ext_start>0){
                $ext = substr($post->guid, $ext_start);
            }

            $form_fields["mediashort1"] = array(
               "label" => __("MediaShort","mediashort"),
               "input" => "html",
               "html" =>
                   '<input type="text" readonly="readonly" value="'.$url.'" onclick="jQuery(this).focus(); jQuery(this).select();" /><br/>' .
                   '<input type="text" readonly="readonly" value="'.$url . $ext.'" onclick="jQuery(this).focus(); jQuery(this).select();" /><br/>' .
                   '<input type="text" readonly="readonly" value="'.$url . '/' . $post->post_name.'" onclick="jQuery(this).focus(); jQuery(this).select();" /><br/>' .
                   '<input type="text" readonly="readonly" value="'.$url . '/' . $post->post_name . $ext.'" onclick="jQuery(this).focus(); jQuery(this).select();" /><br/>' .
                   '<em>&nbsp;'.__("Urls are equivalent and leads to this media as File URL!","mediashort").'</em>'
            );

        }

        return $form_fields;

    }

}

?>