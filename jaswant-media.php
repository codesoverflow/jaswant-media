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

$isCdnContentEnabled = defined("WP_CONTENT_URL");

$jmCdnImgUrl = $isCdnContentEnabled ? WP_CONTENT_URL : '';
   

   
   //wp_get_attachment_metadata
   //wp_get_attachment_image_src

   // wp_calculate_image_srcset_meta
   // $image_meta = apply_filters( 'wp_calculate_image_srcset_meta', $image_meta, $size_array, $image_src, $attachment_id );


   // apply_filters( 'wp_get_attachment_image_src', $image, $attachment_id, $size, $icon );

//apply_filters( 'wp_calculate_image_sizes', $sizes, $size, $image_src, $image_meta, $attachment_id );

//$sources = apply_filters( 'wp_calculate_image_srcset', $sources, $size_array, $image_src, $image_meta, $attachment_id );
   

//the_post_thumbnail( 'small-thumb' );    

// if ( !extension_loaded('gd') || !function_exists('gd_info') ) {
//     echo 'GD Library Not Installed';
// } else {
//     echo 'GD Library Available';
// }

// die;



$thumbnailsToGenerate = array(
    // 'original'=> array(
    //     'height' => 500,
    //     'width' => 500
    // ),
    'thumbnail' => array(
        'height' => 150,
        'width' => 150
    ),
    'td_80x60'=> array(
        'height' => 80,
        'width' => 60
    ),
    'td_100x70'=> array(
        'height' => 100,
        'width' => 70
    ),
);

foreach($thumbnailsToGenerate as $thumbKey => $thumbnailToGenerate) {
    add_image_size($thumbKey, $thumbnailToGenerate['height'], $thumbnailToGenerate['width'], true );
}



if($isCdnContentEnabled) {

    add_filter('wp_get_attachment_url', 
    'wp_get_attachment_url_jm', 10, 3);


    add_filter('wp_calculate_image_srcset', 
    'wp_calculate_image_srcset_jm', 10, 3);
}

    


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

    return $jmCdnImgUrl.'/'.$imgSecondPart;
}
