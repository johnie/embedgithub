<?php
/*
* Plugin Name: Embed Github
* Plugin URI: https://github.com/johnie/embedgithub
* Description: Simply embed Github Readme or Changelog to page or post
* Version: 0.0.1
* Author: Johnie Hjelm
* Author URI: http://johnie.se
* License: MIT
*/

/*
Copyright 2015 Johnie Hjelm <johniehjelm@me.com> (http://johnie.se)

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

// Require Michelf Markdown
require_once __DIR__ . '/vendor/autoload.php';
use \Michelf\Markdown;

if ( ! class_exists( 'EmbedGithub' ) ) {

  class EmbedGithub {

    /**
    * Tag identifier used by file includes and selector attributes.
    * @var string
    */
    protected $tag = 'embedgithub';

    /**
    * User friendly name used to identify the plugin.
    * @var string
    */
    protected $name = 'Embed Github';

    /**
    * Current version of the plugin.
    * @var string
    */
    protected $version = '0.0.1';

    /**
     * Get github readme
     *
     * @access public
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function _eg_shortcode_readme( $atts ) {

      extract( shortcode_atts( array(
        'repo' => 'johnie/embedgithub',
        'trim' => 0
      ), $atts ) );

      $transient="embedgithub_" . $repo . "_" . $trim;
      if ( false === ( $html = get_transient($transient) ) ) {
        $url="https://api.github.com/repos/" . $repo . "/readme";

        $ch = curl_init();
        $timeout = 5;
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WordPress' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        $data = curl_exec( $ch );
        curl_close( $ch );

        $json=json_decode( $data );
        $markdown=base64_decode( $json->content );
        if ( $trim>0 ) {
          $markdown = implode("\n", array_slice(explode("\n", $markdown), $trim));
        }

        $html = Markdown::defaultTransform( $markdown );
        set_transient( $transient, $html , 12 * HOUR_IN_SECONDS );
      }

      return $html;

    }

    /**
    * Initiate the plugin by setting the default values and assigning any
    * required actions and filters.
    *
    * @access public
    */
    function __construct() {

      // Add shortcode
      add_shortcode( $this->tag, array( $this, '_eg_shortcode_readme' ) );

    }

  }

  new EmbedGithub();

}
