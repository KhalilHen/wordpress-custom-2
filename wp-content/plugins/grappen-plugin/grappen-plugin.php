<?php 
/**
 * @package grappendPlugin
 */
/*
Plugin Name: grappen plugin
Plugin URI:  doesn't exist
Description: This is plugin  for a school project.
Version: 1.0.0
Author: kh  
Author URI:  doesn't exist
License: GPLv2 or later
Text Domain: grappen-plugin

*/
if (!defined('ABSPATH')) {
    
    exit;
}

class grappenPlugin {
    

    public function __construct( ) {

    






         add_action('wp_enqueue_scripts', [$this, 'loadAssets']);
         add_action('admin_init', [$this, 'jokesRegisterSettings']);
         add_action('admin_menu', [$this, 'jokesMenu']);




        add_shortcode('fetch_random_joke', array($this,  'fetchRandomJoke'));
        add_shortcode('fetch_random_dev_joke', array($this,  'fetchRandomDevJoke'));
        add_shortcode('fetch_random_joke_based_on_category', array($this,  'fetchRandomJokeBasedOnCategory'));
        add_shortcode('fetch_a_joke_based_on_settings', [$this, 'fetchAJokeBasedOnSettings']);




    }


public function jokesRegisterSettings() {
    register_setting('jokes_options_group', 'jokes_category');
}

public  function jokesMenu() {
    add_menu_page(
        'Jokes Settings',
        'Jokes settings',
        'manage_options',
        'jokes_settings',
        [$this, 'jokesSettingsPage'],
        'dashicons-smiley',
        4
    );
}

public function jokesSettingsPage() {
    ?>
    <div class="wrap">
        <h1>Joke Category Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('jokes_options_group'); ?>
            
            <h3>Select Joke Category</h3>
            <?php $category = get_option('jokes_category', 'dev'); ?>
            
            <label>
                <input type="radio" name="jokes_category" value="dev" <?php checked($category, 'dev'); ?>>
                Dev Jokes
            </label><br>
            
            <label>
                <input type="radio" name="jokes_category" value="science" <?php checked($category, 'science'); ?>>
                Science Jokes
            </label><br>
            
            <label>
                <input type="radio" name="jokes_category" value="food" <?php checked($category, 'food'); ?>>
                Food Jokes
            </label><br><br>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}




 public function fetchAJokeBasedOnSettings() {

        $category = get_option('jokes_category', 'dev');

     $response = wp_remote_get("https://api.chucknorris.io/jokes/random?category=$category");
        $body  = wp_remote_retrieve_body($response);
        $data  = json_decode($body);
        $joke = esc_html($data->value);

 


            return  $joke;}


















  


    public function loadAssets () {

            // voor css laden
        wp_enqueue_style(

            'grappen-plugin',
            plugin_dir_url(__FILE__). '/css/grappen.css',
            array(),
            1, 
            'all',

        ); 
        // Voor de js
        // wp_enqueue_scripts(
        //     'grappen-plugin',
        //     plugin_dir_url(__FILE__). 'js/grappen-plugin.js',
        //     $deps:array,
        //     $ver:string|boolean|null, 
        //     $in_footer:boolean

        // )
    }
    public function fetchRandomJoke() {


        $response = wp_remote_get("https://api.chucknorris.io/jokes/random");
        $body  = wp_remote_retrieve_body($response);
        $data  = json_decode($body);
        // $joke = esc_url($data->value);
        $joke = esc_html($data->value);

 


            return $joke;
 
    }


      public function  fetchRandomDevJoke() {


        $response = wp_remote_get("https://api.chucknorris.io/jokes/random?category=dev");
        $body  = wp_remote_retrieve_body($response);
        $data  = json_decode($body);
        $joke = esc_html($data->value);

 


            return  $joke;
 
    }

      public function  fetchRandomJokeBasedOnCategory($atts) {


            $category = $atts['string'] ?? 'dev';

        $response = wp_remote_get("https://api.chucknorris.io/jokes/random?category={$category}");
        $body  = wp_remote_retrieve_body($response);
        $data  = json_decode($body);
        $joke = esc_html($data->value);

 


            return  $joke;
 
    }

    public function fetchPossibleCategorys() {
        


    }



    



}
new grappenPlugin;