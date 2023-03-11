<?php
class ApprexShortcode {
     public static function shortcode($atts, $content, $tag = '') {
          $html = "";
     
          // Things that you want to do. 
          $settings = get_option('apprex_options');
          // override default attributes with user attributes
          $apprex_atts = shortcode_atts(
               array(
                    'debug' => false,
                    'url_academy' => null,
                    'category_id' => null,
                    'filter_title' => null,
                    'affiliate' => null,
                    'campaign' => null,
                    'type' => "articles",
                    'hide_price' => 0,
                    'cols' => 3,
                    'max' => 4,
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
          $cols = round(12 / $apprex_atts["cols"]);
          $available_types = array("articles", "courses", "posts", "plans", "products", "events");
          $max = $apprex_atts["cols"] ?? 6;
          $reqResource = in_array($apprex_atts["type"], $available_types) ? $apprex_atts["type"] : "articles";
          try {
               $reqUrl = $url. "api/".$reqResource."?".http_build_query(array(
                    "filter[title]" => $apprex_atts["filter_title"], 
                    "filter[categories.id]" => $apprex_atts["category_id"], 
                    "page[size]" => $max
               ));
               $response = @$WP_Http_Curl->request($reqUrl , ['headers' => ['accept' => 'application/json']]);
               if (is_array($response) && isset($response["body"]) && !isset($response["errors"])) {
                    $articles = json_decode($response["body"]);
               } else {
                    $html .= "<div>Beim Abruf der Produkte (".$url.") ist ein Fehler unterlaufen.</div>";
               }
               if(count($articles->data) > 0) {
                    $html .= "<div class=\"apprex-row \">\n";
                    foreach ($articles->data as $article) {
                         if (!isset($article->id) || !isset($article->title)) { continue; }
                         $reqQuery = "?".http_build_query(array("utm_source" => "app_wordpress", "aff" => $apprex_atts["affiliate"], "cam" => $apprex_atts["campaign"]));
                         $resource = $article->product_type."s"; // course+s, product+s, event+s, post+s
                         $html .= "<a href=\"".$url.$resource."/".$article->slug."/".$reqQuery."\" target=\"_blank\" class=\"apprex-column apprex-col-".$cols."\">\n";
                              $html .= "<img src=\"" . $article->image_url . "\">\n";
                              $html .= "<div class=\"apprex-title-and-price\">";
                                   $html .= "<h2 class=\"apprex-title\">" . $article->title . "</h2>\n";
                                   if(!empty($article->current_price) && $apprex_atts["hide_price"] != 1) {
                                        $html .= "<p class=\"apprex-price\">" . $article->current_price . " € </p> <br>\n";
                                   }
                                   $html .= "</div>";
                              $html .= "<p class=\"apprex-content_excerpt\">" . $article->content_excerpt . "</p>\n";
                              if(isset($article->modules_count)) {
                                   $html .= "<i>Der Kurs beinhaltet " . $article->modules_count . " Module </i>\n";
                              }
                              $html .= "<button class=\"apprex-button\">Mehr erfahren...</button>\n";
                         $html .= "</a>\n";
                    }
                    $html .= "</div>";
               } else {
                    $html .= "<div>Es konnten keine Artikel gefunden werden</div>";
               }
               $html .= "</div>";
          } catch (\WP_Error $e) {
               return "<!-- e1 --></div>";
               // there seems to be something wrong
          } catch (\Exception $e) {
               return "<!-- e2 --></div>";
               // also..
          }
     }
}