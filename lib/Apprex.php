<?php
require_once('ApprexShortcode.php');

class Apprex {
     public function __construct() {
          
     }
     public function shortcode($atts, $content, $tag) {
          return ApprexShortcode::shortcode($atts, $content, $tag);
     }
}