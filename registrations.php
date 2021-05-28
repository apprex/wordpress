<?php
// Stop direct calling of this file
if (!defined('WPINC')) { die; } 
require_once('lib/Apprex.php');

$apprex = new Apprex();
/**
 * Style 
 * */
function apprex_css() {
     wp_enqueue_style('apprex-style', plugin_dir_url(__FILE__) . 'apprex.css');
} // call the method apprex_css()
add_action('wp_enqueue_scripts', 'apprex_css');

/**
 * Shortcode
 * */
function apprex_shortcode($atts, $content, $tag = '') {
     global $apprex;
     return $apprex->shortcode($atts, $content, $tag);
} // register shortcode
add_shortcode('apprex', 'apprex_shortcode');
