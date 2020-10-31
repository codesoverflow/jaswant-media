<?php
   /*
   Plugin Name: Jaswant Media Plugin
   Plugin URI: https://bhajandiary.com
   description: >- Plugin to do operations on media
   Version: 1.0
   Author: Mr. Jaswant Mandloi
   Author URI: https://bhajandiary.com
   License: GPL2
   */

   require_once 'config.php';
   

   
   //wp_get_attachment_metadata
   //wp_get_attachment_image_src

   // wp_calculate_image_srcset_meta
   // $image_meta = apply_filters( 'wp_calculate_image_srcset_meta', $image_meta, $size_array, $image_src, $attachment_id );


   // apply_filters( 'wp_get_attachment_image_src', $image, $attachment_id, $size, $icon );

//apply_filters( 'wp_calculate_image_sizes', $sizes, $size, $image_src, $image_meta, $attachment_id );

   

   add_filter('wp_get_attachment_url', 
    'wp_get_attachment_url_jm', 10, 3);


    add_filter('wp_calculate_image_srcset', 
    'wp_calculate_image_srcset_jm', 10, 3);

    //$sources = apply_filters( 'wp_calculate_image_srcset', $sources, $size_array, $image_src, $image_meta, $attachment_id );


    function wp_calculate_image_srcset_jm($sources) {
        
        
        foreach($sources as $sourceKey => $source) {
            $updateUrl = jm_replace_image_url($source['url']);
            $sources[$sourceKey]['url'] = $updateUrl;
        }

        return $sources;
    }


    function wp_get_attachment_url_jm($url, $post_id) {

        return jm_replace_image_url($url);
    }

    function jm_replace_image_url($url) {
        global $jmCdnImgUrl;

        if(is_admin()) {
            return $url;
        }

        $imgUrlArr = explode('/wp-content/', $url);
        if(count($imgUrlArr) != 2 ) {
            return $url;
        }

        $imgSecondPart = $imgUrlArr[1];

        return $jmCdnImgUrl.$imgSecondPart;
    }
   

?>