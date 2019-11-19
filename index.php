<?php

/*
* Plugin Name: DateThemePlugin
* Description: making a work-space-theme based on the time of the day, with a greeting as well
* Version: 1.0
* Author: Freddy
* Author URI: http
* Text Domain:  
*/




if (!function_exists('add_action')) {
    echo "Go Away. We know all your tricks";
    exit;
}
      

class datefreddyplugin {

    function __construct()
    {
        add_action('init' , array($this, 'dateToggle'));
    }
    
            //  Styling;
    function MorningFreddy() {
            $src = plugins_url( './morning.css',    __FILE__ );
            wp_enqueue_style( 'MorningFreddy', $src, '');
        }

    function EveningFreddy() {
            $src = plugins_url( './evening.css',    __FILE__ );
            wp_enqueue_style( 'EveningFreddy', $src, '');
        }

    function MiddayFreddy() {
            $src = plugins_url( './midday.css',    __FILE__ );
            wp_enqueue_style( 'MiddayFreddy', $src, '');
        }

             // aktivering
    function dateToggle() {
            $time = date("H");
            if($time >= "21" && $time <= "24") {
                add_action('admin_enqueue_scripts' , array($this, 'EveningFreddy'));
            } else if($time >= "12" && $time <= "21") {
                add_action('admin_enqueue_scripts' , array($this, 'MiddayFreddy'));
            } else {
                add_action('admin_enqueue_scripts' , array($this, 'MorningFreddy'));
            }
        }      
}

$datefredObj = new datefreddyplugin();
            //hook               //class                //callback-function
add_filter('the_content', array('greet_modifier', 'correct_greeting'));

class greet_modifier {          //content=loaded wp-content
    function correct_greeting($content)
    {
        $time = date("H");
        if($time >= "21" && $time <= "24") {
            $content = str_replace('Hello User', 'Goodevening User. Lean back and enjoy the cozy night', $content);
            return $content;
        } else if($time >= "12" && $time <= "21") {
            $content = str_replace('Hello User', 'Good-day User. Enjoy the day while you can', $content);
            return $content;
        } else {
            $content = str_replace('Hello User', 'Goodmorning User. It is time to enjoy a beautyful day', $content);
            return $content;
        }
    }

}


