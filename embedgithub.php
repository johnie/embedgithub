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

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// Require Michelf Markdown
require_once 'Michelf/Markdown.inc.php';
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
    * Initiate the plugin by setting the default values and assigning any
    * required actions and filters.
    *
    * @access public
    */
    function __construct() {

      

    }

  }

  new EmbedGithub();

}
