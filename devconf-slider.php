<?php
/*
Plugin Name: Dev Conf Slider
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is a slider plugin
Author: Rezaun Kabir
Version: 1.0
Author URI: https://rezaun.netlify.app/
*/

function devconf_register_cpt(){
    $labels=[
        'name' =>'DevConf Slider'
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'supports' =>['title', 'editor','thumbnail', 'page-attributes']
    ];

register_post_type('devconf-slider', $args);    
}
add_action('init','devconf_register_cpt');



function devconf_slider_shortcode(){
    $args = [
        'post_type' =>'devconf-slider',
        'posts_per_page' => -1
    ];

    $query = new WP_Query($args);
    
    
    $html = '
    <script>
    jQuery(document).ready(function($){
        $(".devconf-slider").slick({
            autoplay:true,
            arrows:false
        });
    });
    </script>
    <div class="devconf-slider">';

    while($query->have_posts()) : $query->the_post();

    $html .='<div class="single-slider-item" style="background-image:url('.get_the_post_thumbnail_url(get_the_ID(), 'large').')">
        <div class="devconf-slider-content">
            <h3>'.get_the_title().'</h3>
            '.wpautop(get_the_content()).'
        </div>
    </div>';

    endwhile; wp_reset_query();

    $html .= '</div>';

    return $html;

}
add_shortcode('devconf_slider', 'devconf_slider_shortcode');


function devconf_plugin_assets(){

    $plugin_dir_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('slick', $plugin_dir_url.'assets/css/slick.css');
    wp_enqueue_script('slick', $plugin_dir_url.'assets/js/slick.min.js', ['jquery'], '1.0', true);

}
add_action('wp_enqueue_scripts', 'devconf_plugin_assets');