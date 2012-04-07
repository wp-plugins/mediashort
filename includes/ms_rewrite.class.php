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
        $settings = new MediaShort_Settings();
        if ($settings->active){
            $new_rules = array( $settings->tag.'/(.+?)/?$' => 'index.php?mediashort='.$wp_rewrite->preg_index(1) );
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
            $post = get_post($id);

            $attachment = (int)get_post_meta($id, '_mediashort_attachment',true);

            $settings = new MediaShort_Settings();

            if ($settings->transfer=='file'){

                header('Content-Type: ' . $post->post_mime_type);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . getimagesize($post->guid));
                header('Content-Description: File Transfer');

                if ($attachment){
                    header('Content-Disposition: attachment; filename='.basename($post->post_name));
                }

                readfile($post->guid);

            }
            else if ($settings->transfer=='curl'){

                header('Content-Type: ' . $post->post_mime_type);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . getimagesize($post->guid));
                header('Content-Description: File Transfer');

                if ($attachment){
                    header('Content-Disposition: attachment; filename='.basename($post->post_name));
                }

                ob_clean();
                flush();

                $c = curl_init();
                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($c, CURLOPT_URL, $post->guid);
                $contents = curl_exec($c);
                curl_close($c);
                echo $contents;
            }
            else{
                wp_redirect($post->guid);
            }
            exit;
        }
    }

}


?>