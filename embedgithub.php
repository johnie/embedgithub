<?php

/*
* Plugin Name: Embed GitHub
* Plugin URI: https://github.com/johnie/embedgithub
* Description: Simply embed GitHub Readme or any other markdown file to page or post
* Version: 1.0.0
* Author: Johnie Hjelm
* Author URI: http://johnie.se
* License: MIT
*/

/*
Copyright 2015-2016 Johnie Hjelm <johniehjelm@me.com> (http://johnie.se)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use \Michelf\Markdown;

class EmbedGitHub {

  /**
   * Tag identifier used by file includes and selector attributes.
   *
   * @var string
   */
  protected $tag = 'embedgithub';

  /**
   * User friendly name used to identify the plugin.
   *
   * @var string
   */
  protected $name = 'Embed GitHub';

  /**
   * Current version of the plugin.
   *
   * @var string
   */
  protected $version = '1.0.1';

  /**
   * Get GitHub readme or file.
   *
   * @param  array $atts
   *
   * @return string
   */
  public function _eg_shortcode_readme( $atts ) {
    $atts = shortcode_atts( array(
      'repo' => 'johnie/embedgithub',
      'file' => false,
      'trim' => 0
    ), $atts );

    $transient = 'embedgithub_' . $atts['repo'] . '_' . $atts['file'] . '_' . $atts['trim'];
    if ( false === ( $html = get_transient( $transient ) ) ) {
      if ( $atts['file'] ) {
        $url = 'https://api.github.com/repos/' . $atts['repo'] . '/contents/' . $atts['file'];
      } else {
        $url = 'https://api.github.com/repos/' . $atts['repo'] . '/readme';
      }

      $ch = curl_init();
      $timeout = 5;
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_USERAGENT, 'WordPress' );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
      $data = curl_exec( $ch );
      curl_close( $ch );

      $json = json_decode( $data );
      $markdown = base64_decode( $json->content );

      if ( $atts['trim'] > 0 ) {
        $markdown = implode( "\n", array_slice( explode( "\n", $markdown ), $atts['trim'] ) );
      }

      $html = Markdown::defaultTransform( $markdown );
      set_transient( $transient, $html , 12 * HOUR_IN_SECONDS );
    }

    return $html;
  }

  /**
   * Initiate the plugin by setting the default values and assigning any
   * required actions and filters.
   */
  public function __construct() {
    add_shortcode( $this->tag, array( $this, '_eg_shortcode_readme' ) );
  }
}

new EmbedGitHub();
