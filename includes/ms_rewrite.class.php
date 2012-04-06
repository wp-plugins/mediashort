<?php

$ms_rewrite = new MediaShort_Rewrite();

class MediaShort_Rewrite{

    function __construct(){

        add_filter('generate_rewrite_rules', array(&$this,'ms_rewrite_rules'));

        add_filter('query_vars', array(&$this,'query_vars'));
        add_action('parse_request', array(&$this, 'parse_requests'));

    }

    function ms_rewrite_rules( $wp_rewrite )
    {
        $mediashort_settings = get_option( 'mediashort-settings', '');
        $active = $mediashort_settings['active'];
        $tag = empty($mediashort_settings['tag']) ? 'ms' : $mediashort_settings['tag'];

        if ($active){
            $new_rules = array( $tag.'/(.+?)/?$' => 'index.php?mediashort='.$wp_rewrite->preg_index(1) );
            $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
        }
    }

    function query_vars($vars) {
        $vars[] = 'mediashort';
        return $vars;
    }

    function parse_requests($wp)
    {
        if (array_key_exists('mediashort', $wp->query_vars))
        {
            $id = $wp->query_vars['mediashort'];
            wp_redirect(wp_get_attachment_url($id));
            exit;
        }
    }

}


?>