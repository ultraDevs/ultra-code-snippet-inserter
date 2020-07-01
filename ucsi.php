<?php

/**
 * @package ultraCodeSnippetInserter
 * Plugin Name:     Ultra Code Snippet Inserter
 * Plugin URI:      https://ultradevs.com/shop/wp/plugins/ultra-code-snippet-inserter
 * Description:     Ultra Code Snippet Inserter allows you to create Wordpress shortcodes to your code. It will help you to write custom HTML, CSS, PHP, JAVASCRIPT code easily in Wordpress Page Builder like Divi, Elementor, WPBakery Page Builder, etc. 
 * Version:         1.0.0
 * Author:          ultraDevs
 * Author URI:      https://ultradevs.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     ucsi
 * Domain Path:     /languages
 */

defined( 'ABSPATH') || die( 'Hello !!!');

/**
 * Require Composer Autoload
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use Inc\Base\Activate;

/**
 * The code run after plugin activation
 */
function ucsi_activate() {
    Activate::activate();
}
register_activation_hook( __FILE__ , 'ucsi_activate');

if ( class_exists( 'Inc\\Init')) {
    Inc\Init::registerServices();
}
