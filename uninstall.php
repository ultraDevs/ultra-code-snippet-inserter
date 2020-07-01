<?php 
/**
 * Trigger this file on plugin uninstall
 * @package ultraCodeSnippetInserter
 */
defined( 'WP_UNINSTALL_PLUGIN') or die('Hello !');

function UD_ucsi_uninstall() {
    global $wpdb;

    $wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ud_short_code' ) );
}

UD_ucsi_uninstall();