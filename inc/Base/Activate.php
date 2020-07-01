<?php
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc\Base;

defined('ABSPATH') || die(); 

/**
 * Activator Class
 */
class Activate extends BaseController
{
    /**
     * Activation
     */
    public static function activate() {
        /**
         * Create Table
         */
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

        $udci_tbl_c = $wpdb->prefix .'ud_short_code';
        $udci_charset_collale = $wpdb->get_charset_collate();
        
        $Query = "CREATE TABLE IF NOT EXISTS $udci_tbl_c(
            id int(11) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            content text NOT NULL,
            short_code varchar(255) NOT NULL,
            status int NOT NULL,
            created_at text NOT NULL,
            updated_on text NOT NULL,
            PRIMARY KEY(id)
        ) $udci_charset_collale";

        dbDelta( $Query );
    }
    /**
     * Admin Notice
     */
    public function AdminNotice() {
        ?>
        <div class="updated notice is-dismissible">
            <p>Thank you for using this plugin! <strong>You are awesome</strong>.</p>
        </div>
        <?php
    }
}