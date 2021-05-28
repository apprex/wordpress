<?php
class ApprexShortcode {
     public static function shortcode($atts, $content, $tag = '') {
          $html = "";
     
          // Things that you want to do. 
          $settings = get_option('apprex_options');
          // override default attributes with user attributes
          $apprex_atts = shortcode_atts(
               array(
                    'url_academy' => null,
                    'category_id' => null,
                    'filter'      => array(),
               ), $atts, $tag
          );

          if (isset($apprex_atts["url_academy"]) && !empty($apprex_atts["url_academy"]) && filter_var($apprex_atts["url_academy"], FILTER_VALIDATE_URL) !== FALSE) {
               if (substr($apprex_atts["url_academy"], -1) != "/") { // end sign should be a slash
                    $url = $apprex_atts["url_academy"]."/";
               } else {
                    $url = $apprex_atts["url_academy"];
               }
          } else if (isset($settings["apprex_academy_url"]) && !empty($settings["apprex_academy_url"])) {
               $url = $settings["apprex_academy_url"];
               $atts = array_change_key_case( (array) $atts, CASE_LOWER );#
          } else {
               return "<!-- wrong settings -->";
          }

          self::makeRequest($url, $apprex_atts, $html);
     
          // Output needs to be return
          return $html;
     }

     public static function makeRequest($url, $apprex_atts, &$html) {
          $html .= "<!--- arx_plugin --> <div class=\"apprex-container\">";
          $WP_Http_Curl = new WP_Http_Curl();
          try {
               $reqUrl = $url. "api/courses?";
               if (isset($apprex_atts["filter_title"]) && $apprex_atts["filter_title"] != null) { $reqUrl .= "&filter[title]=".$apprex_atts["filter_title"]; }
               $response = @$WP_Http_Curl->request($reqUrl , ['headers' => ['accept' => 'application/json']]);
               if (is_array($response) && isset($response["body"])) {
                    $courses = json_decode($response["body"]);
                    $html .= "<div class=\"apprex-row \">\n";
                    foreach ($courses as $course) {
                         if (!isset($course->id) || !isset($course->title) || !isset($course->currentPrice)) { continue; }
                         $html .= "<div class=\"apprex-column apprex-col-4\">\n";
                         $html .= "<img src=\"" . $course->image_url . "\">\n";
                         $html .= "<strong>" . $course->title . "</strong>\n";
                         $html .= "<p>" . $course->content_excerpt . "</p>\n";
                         $html .= "<strong>" . $course->currentPrice . " € </strong> <br>\n";
                         if(isset($course->modules_count)) {
                              $html .= "<i>Der Kurs beinhaltet " . $course->modules_count . " Module </i>\n";
                         }
                         $html .= "<a href=\"".$url."courses/".$course->slug."/?utm_source=app_wpp\" target=\"_blank\" class=\"apprex-button\">Mehr erfahren...</a>\n";
                         $html .= "</div>\n";
                    }
                    $html .= "</div>";
               } else if (isset($response->errors)) {
                    $html .= "Beim Abruf unserer Kurse (".$url.") ist ein Fehler unterlaufen. ";
               }
               $html .= "</div>";
          } catch (\WP_Error $e) {
               return "<!-- e1 -->";
               // there seems to be something wrong
          } catch (\Exception $e) {
               return "<!-- e2 -->";
               // also..
          }
     }
}