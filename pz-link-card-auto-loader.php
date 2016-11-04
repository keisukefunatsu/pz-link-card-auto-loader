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

//本文中のURLをはてなブログカードタグに変更する
function url_to_blog_card($the_content) {
  if ( is_singular() ) {//投稿ページもしくは固定ページのとき
    //1行にURLのみが期待されている行（URL）を全て$mに取得
    $res = preg_match_all('/^(<p>)?(<a.+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(<\/p>)?(<br ? \/>)?$/im', $the_content,$m);
    //マッチしたURL一つ一つをループしてカードを作成
    foreach ($m[0] as $match) {
      $url = strip_tags($match);//URL

      //取得した情報からブログカードのHTMLタグを作成
      $tag = do_shortcode('[blogcard url=' . $url . ']');
      //本文中のURLをブログカードタグで置換
      $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
    }
  }
  return $the_content;//置換後のコンテンツを返す
}
add_filter('the_content','url_to_blog_card');//本文表示をフック
