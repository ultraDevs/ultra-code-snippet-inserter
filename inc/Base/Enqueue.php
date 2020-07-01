<?php 
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc\Base;

defined('ABSPATH') || die();

/**
 * Enqueue Scripts
 */
class Enqueue extends BaseController
{
    /**
     * Enqueue public styles
     */
    public function enqueuePublicStyles()  {
        wp_enqueue_style( $this->pluginName .'-main-css', $this->pluginUrl . 'assets/public/css/ucsi.css', '', $this->version);
    }
    /**
     * Enqueue public styles
     */
    public function enqueuePublicScripts() {
        wp_enqueue_script( $this->pluginName . '-main-js', $this->pluginUrl . 'assets/public/js/ucsi.js', '', $this->version);
    }

    /**
     * Enqueue Admin styles
     * 
     * @param string $hook
     */
    public function enqueueAdminStyles( $hook) {

        global $ucsiMainMenu;
        $allowed = array( $ucsiMainMenu );
        if ( !in_array( $hook, $allowed)  ) {
            return;
        }
        wp_enqueue_style( $this->pluginName .'-main-css', $this->pluginUrl . 'assets/admin/css/ucsi.css', '', $this->version);
        
    }
    /**
     * Enqueue Admin Script
     * 
     * @param string $hook
     */
    public function enqueueAdminScripts( $hook) {

        // CodeMirror.

        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
            'type' => 'text/css',
            'type' => 'text/html',
            'type' => 'text/javascript',
            'type' => 'application/json',
            'type' => 'application/x-httpd-php',
        ));
        wp_localize_script('jquery', 'cm_settings', $cm_settings);
        
        wp_enqueue_script('wp-theme-plugin-editor');
        wp_enqueue_style('wp-codemirror');

        // var_dump( $hook);
        global $ucsiMainMenu;
        $allowed = array( $ucsiMainMenu );
        if( !in_array( $hook, $allowed)  ) {
            return;
        }
        wp_enqueue_script( $this->pluginName . '-main-js', $this->pluginUrl . 'assets/admin/js/ucsi.js', array( 'jquery'), $this->version, true);
    }

    /**
     * Register Method
     */
    public function register() {
        // Public
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueuePublicStyles'));
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueuePublicScripts'));

       // Admin
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueAdminStyles'));
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueAdminScripts'));
    }
}