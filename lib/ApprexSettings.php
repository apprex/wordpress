<?php
class ApprexSettings {
     private $apprexSettings_options;

     /* 
     * Retrieve this value with:
     * $apprexSettings_options = get_option( 'apprex_options' ); // Array of All Options
     * $apprex_academy_url = $apprexSettings_options['apprex_academy_url']; // URL deiner Akademie:
     * $apprex_api_key = $apprexSettings_options['apprex_api_key']; // apprex API Key
     * $apprex_max_courses = $apprexSettings_options['apprex_max_courses']; // Maximale Kursanzahl
     */


     public function __construct()
     {
          add_action('admin_menu', array($this, 'apprexSettings_add_plugin_page'));
          add_action('admin_init', array($this, 'apprexSettings_page_init'));
     }

     public function apprexSettings_add_plugin_page()
     {
          add_options_page(
               'Apprex Einstellungen', // page_title
               '🚀 Apprex', // menu_title
               'manage_options', // capability
               'apprex-einstellungen', // menu_slug
               array($this, 'apprexSettings_create_admin_page') // function
          );
     }

     public function apprexSettings_create_admin_page()
     {
          $this->apprexSettings_options = get_option('apprex_options'); ?>

          <div class="wrap">
               <h2>Apprex Einstellungen</h2>
               <p>Füge deine apprex Akademie mit wenigen Schritten zu deiner WordPress Instanz hinzu oder nutze individuell unsere Shortcodes.</p>
               <?php settings_errors(); ?>

               <form method="post" action="options.php">
                    <?php
                    settings_fields('apprexSettings_option_group');
                    do_settings_sections('apprex-einstellungen-admin');
                    submit_button();
                    ?>
               </form>

               <h2>Shortcodes für apprex</h2>
               <p>Wenn du die oberen Einstellungen für deine WordPress Seite getätigt hast, reicht der normale Shortcut, für die Standart Darstellung</p>
               <code>[apprex]</code>
               <p>Du kannst aber jederzeit die Parameter <code>url_academy</code>, <code>api_key</code> und <code>max_courses</code> an den Shortcode übergeben</p>
               <code>[apprex url_academy="https://deine-url.apprex.net"]</code>
               <h2>Weitere Attribute</h2>
               <p>Wenn Du filtern möchtest, so kannst Du mithilfe von <code>filter_title="Test"</code> alle Kurse filtern, deren Titel "Test" sind.</p>
          </div>
<?php }

     public function apprexSettings_page_init()
     {
          register_setting(
               'apprexSettings_option_group', // option_group
               'apprex_options', // option_name
               array($this, 'apprexSettings_sanitize') // sanitize_callback
          );

          add_settings_section(
               'apprexSettings_setting_section', // id
               'Settings', // title
               array($this, 'apprexSettings_section_info'), // callback
               'apprex-einstellungen-admin' // page
          );

          add_settings_field(
               'apprex_academy_url', // id
               'URL deiner Akademie:', // title
               array($this, 'apprex_academy_url_callback'), // callback
               'apprex-einstellungen-admin', // page
               'apprexSettings_setting_section' // section
          );

          add_settings_field(
               'apprex_api_key', // id
               'apprex API Key', // title
               array($this, 'apprex_api_key_callback'), // callback
               'apprex-einstellungen-admin', // page
               'apprexSettings_setting_section' // section
          );

          add_settings_field(
               'apprex_max_courses', // id
               'Maximale Kursanzahl', // title
               array($this, 'apprex_max_courses_callback'), // callback
               'apprex-einstellungen-admin', // page
               'apprexSettings_setting_section' // section
          );
     }

     public function apprexSettings_sanitize($input)
     {
          $sanitary_values = array();
          if (isset($input['apprex_academy_url'])) {
               if (filter_var($input['apprex_academy_url'], FILTER_VALIDATE_URL) === FALSE) {
                    die('Not a valid URL');
               } else {
                    if (substr($input['apprex_academy_url'], -1) != "/") { // end sign should be a slash
                         $sanitary_values['apprex_academy_url'] = sanitize_text_field($input['apprex_academy_url']."/");
                    } else {
                         $sanitary_values['apprex_academy_url'] = sanitize_text_field($input['apprex_academy_url']);
                    }
               }
          }

          if (isset($input['apprex_api_key'])) {
               $sanitary_values['apprex_api_key'] = sanitize_text_field($input['apprex_api_key']);
          }

          if (isset($input['apprex_max_courses']) && $input['apprex_max_courses'] > 0) {
               $sanitary_values['apprex_max_courses'] = sanitize_text_field(intval($input['apprex_max_courses']));
          } else {
               $sanitary_values['apprex_max_courses'] = sanitize_text_field(0);
          }

          return $sanitary_values;
     }

     public function apprexSettings_section_info()
     {
     }

     public function apprex_academy_url_callback()
     {
          printf(
               '<input class="regular-text" type="text" name="apprex_options[apprex_academy_url]" id="apprex_academy_url" value="%s">',
               isset($this->apprexSettings_options['apprex_academy_url']) ? esc_attr($this->apprexSettings_options['apprex_academy_url']) : ''
          );
     }

     public function apprex_api_key_callback()
     {
          printf(
               '<input class="regular-text" type="text" placeholder="optional" name="apprex_options[apprex_api_key]" id="apprex_api_key" value="%s">',
               isset($this->apprexSettings_options['apprex_api_key']) ? esc_attr($this->apprexSettings_options['apprex_api_key']) : ''
          );
     }

     public function apprex_max_courses_callback()
     {
          printf(
               '<input class="regular-text" type="text" name="apprex_options[apprex_max_courses]" id="apprex_max_courses" value="%s">',
               isset($this->apprexSettings_options['apprex_max_courses']) ? esc_attr($this->apprexSettings_options['apprex_max_courses']) : ''
          );
     }
}