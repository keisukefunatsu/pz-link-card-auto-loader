<?php
/*
Plugin Name: Pz-LinkCard-Auto-Loader
Plugin URI:  https://awe-some.net
Description: This plugin will convert all links written in a line to Pz-LinkCard
Version:     1.0
Author:      Keisuke Funatsu
Author URI:  https://awe-some.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// include 'ChromePhp.php';
// ChromePhp::log('hello');



defined('ABSPATH') || die;

class Pz_Linkcard_Auto_Loader {
  public function __construct(){
    register_activation_hook(__FILE__, array($this, 'activation' ));
    add_action('admin_menu', array($this, 'add_menu'));
    add_filter('the_content', array($this, 'auto_load'));
    if( get_option('customcss1') == 'true' ) {
      add_action( 'wp_enqueue_scripts', array ( $this, 'load_my_style' ));
    }
  }
  public function activation() {
    if ( ! get_option('customcss1' )) {
      add_option( 'customcss1' , $value = true, null, $autoload = 'yes');
    }
  }


  // replace all one line links to blogcard
  public function auto_load($the_content) {
    if ( is_singular() ) {
      $res = preg_match_all('/^(<p>)?(<a.+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(<\/p>)?(<br ? \/>)?$/im', $the_content,$m);
      // make cards
      foreach ($m[0] as $match) {
        $url = strip_tags($match);//URL
        $tag = do_shortcode('[blogcard url=' . $url . ']');
        $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
      }
    }
    return $the_content;
  }
  // add menu
  public function add_menu(){
      // add sub menu to setting
    add_options_page('Pz-LinkCard-Auto-Loader', 'Pz-LinkCard-Auto-Loader',
      'manage_options',
      'pz-linkcard-auto-loader-setting-menu',
      array($this, 'setting_page')
    );
  }
  public function setting_page() {
    require_once dirname( __FILE__ ) . '/lib/pz-linkcard-auto-loader-setting.php';
  }
  function load_my_style() {
    wp_enqueue_style( 'hatena', plugin_dir_url( __FILE__ ) . 'hatena-blog-card.css');
  }
}

$autoLoader = new Pz_LinkCard_Auto_Loader();
