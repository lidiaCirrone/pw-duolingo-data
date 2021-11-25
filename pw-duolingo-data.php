<?php

/*
Plugin Name: Duolingo Data
Plugin URI: http://polyglotwannabe.com/
Description: Retrieves data from the unofficial Duolingo API for Python (https://github.com/KartikTalwar/Duolingo)
Version: 1.0
Author: Lidia Cirrone
Author URI: http://polyglotwannabe.com/
*/

function flag_icons_styles()
{
   // check if is_page() == 'duolingo'?
   wp_enqueue_style('flag-icons-main', plugins_url('pw-duolingo-data') . '/flag-icons-main/css/flag-icons.min.css', array(), null);
}
add_action('wp_enqueue_scripts', 'flag_icons_styles');

add_shortcode('pw_duolingo_data', 'duolingo_api_call');
function duolingo_api_call($attributes)
{
   $command = escapeshellarg(__DIR__  . '\pw-load-api.py');
   $output = shell_exec($command);
   $duo = json_decode($output);
   $current_languages = $duo->current_languages;
   // var_dump($duo);
   // {
   //    ["username"]=> "lidiaCirrone"
   //    ["streak"] => 1664
   //    ["learning_language"] => { 
   //       ["abbr"]=> "sv" 
   //       ["string"]=>  "Swedish" 
   //       ["level"]=> ["level_left"]
   //       ["level_percent"]=> 
   //    } 
   //    ["current_languages"]=> {
   //       [0]=> "it" 
   //       [1]=> "es" 
   //       [2]=> "ru" 
   //       [3]=> "pt" 
   //       [4]=> "fr"
   //       [5]=> "de"
   //       [6]=> "da"
   //       [7]=> "sv"
   //    }
   // }



   ob_start();
?>
   <div class="card">
      <div class="card-body small">
         <h5 class="card-title mb-3"><?php echo $duo->username; ?></h5>
         <p class="card-subtitle text-pastel mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16">
               <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z" />
            </svg>
            <?php echo $duo->streak; ?> day streak
         </p>
         <p class="card-subtitle text-pastel mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text" viewBox="0 0 16 16">
               <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
               <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8zm0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
            </svg>
            <?php echo $duo->learning_language->string; ?>
         </p>
         <p class="card-subtitle text-pastel mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
               <path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
            </svg>
            level <?php echo $duo->learning_language->level; ?>/<?php echo $duo->learning_language->level_left; ?>
         </p>
         <div class="card-text my-3">
            all the languages I've been studying on Duolingo up until now:<br>
            <?php foreach ($current_languages as $index => $language) { 
               if ($language == 'da') : ($language = 'dk'); endif; ?>
               <span class="flag-icon flag-icon-<?php echo $language; ?>"></span>
               <?php } ?>
         </div>
         - <a href="https://www.duolingo.com/lidiaCirrone" target="_href" class="card-link">my profile</a><br>
         - <a href="https://duome.eu/lidiaCirrone" target="_href" class="card-link">more statistics on duome.eu</a>
      </div>
   </div>
<?php
   return ob_get_clean();
}
