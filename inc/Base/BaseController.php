<?php 
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc\Base;

defined('ABSPATH') || die();

/**
 * Base Controller Class
 */
class BaseController
{
    public $pluginPath;
    public $pluginUrl;
    public $plugin;
    public $pluginName;
    public $version;
    public function __construct() {
        $this->pluginPath = plugin_dir_path( dirname( __FILE__ , 2) );
        $this->pluginUrl = plugin_dir_url( dirname( __FILE__ , 2) );
        $this->plugin = plugin_basename( dirname( __FILE__ , 3) ) . '/ucsi.php';
        $this->pluginName = 'Ultra PHP Code Snippet Inserter';
        $this->version = '1.0.0';
    }
}