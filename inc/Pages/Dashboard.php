<?php
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;

ob_start();

defined('ABSPATH') || die();

/**
 * Dashboard Class
 */
class Dashboard extends BaseController
{
    /**
     * Page for dashboard
     *
     * @return void
     */
    public function addPage() {
        global $ucsiMainMenu;
        /**
         * Menu
         */
       $ucsiMainMenu = add_menu_page( __( 'Ultra Code Snippet', 'ucsi'), __( 'Code Snippets', 'ucsi'), 'manage_options', 'uc-snippet', array( $this , 'pageIndex'), '', 10);
        /**
         * Sub Menu Pages
         */
        add_submenu_page( 'uc-snippet', __( 'Snippets', 'ucsi'), __( 'All Snippets', 'ucsi'), 'manage_options', 'uc-snippet', array( $this, 'pageIndex'));
        // $ucsiSettings = add_submenu_page( 'uc-snippet', 'Settings', 'Settings', 'manage_options', 'ucsi-settings', array( $this, 'settings'));
    }

    /**
     * Dashboard Page Index
     *
     * @return void
     */
    public function pageIndex() {
        global $wpdb;
        $udci_tbl_c = $wpdb->prefix .'ud_short_code';

        if ( ! current_user_can( 'manage_options') ) {
            return;
        }
        $action  = isset( $_GET['action']) ? sanitize_text_field( $_GET['action']) : 'list';
        switch ( $action) {
            case 'add':
                $_POST = stripslashes_deep( $_POST);
                $errors = array();
                // $success = array();
                if( isset( $_POST['add_s']))
                {
                    $errors     = array();// $success[] = 'Added';
                    $sTitle     = str_replace( ' ', '-', $_POST['stitle']);
                    $sCon       = $_POST['code'];
                    if ( substr(trim( $sCon), 0, 5) == '<?php' ) {
                        
                    } else {
                        $sCon = '<?php ?>' . $sCon;
                    }
                    $sShortCode = '[ucsi snippet="' . strtolower( $sTitle) . '"]';
                    $sDate      = date( get_option( 'date_format' ) . " h:i:s A");
                    $sStatus    = 1;
                    if( !isset( $_POST['_wpnonce']) || !wp_verify_nonce( $_POST['_wpnonce'], '_ucsi'))
                    {
                        wp_nonce_ays( '_ucsi');
                        $errors[] = 'Bad Request';
                        exit();
                    }
                    if( !current_user_can( 'manage_options'))
                    {
                        $errors[] = 'Are you cheating?';
                    }
                    $sCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM $udci_tbl_c WHERE title=%s", $sTitle));
                    
                    if( $sCount > 0)
                    {
                        $errors[] = 'Snippet title already exists!';
                    }

                    if( empty( $_POST['stitle']))
                    {
                        $errors[] = 'Snippet title is required!';
                    }
                    if( empty( $errors)) 
                    {
                        // echo $sCon;
                        $wpdb->insert(
                            $udci_tbl_c,
                            array(
                                'title'      => $sTitle,
                                'content'    => $sCon,
                                'short_code' => $sShortCode,
                                'created_at' => $sDate,
                                'updated_on' => $sDate,
                                'status'     => $sStatus,
                            ),
                            array( '%s', '%s', '%s', '%s', '%s', '%d')
                        );
                        wp_redirect( admin_url( 'admin.php?page=uc-snippet' ));
                        exit();
                    }
                }
                require_once $this->pluginPath . 'templates/Admin/addNew.php';
                break;
            case 'edit':
                $_POST = stripslashes_deep( $_POST);
                if( isset( $_GET['id']))
                {
                    $sID    = intval( $_GET['id']);
                    $sCount = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $udci_tbl_c WHERE id=%d", $sID));
                    $sTitle = $sCount[0]->title;
                    $sCon   = $sCount[0]->content;
                }
                $errors = array();
                // $success = array();
                if( isset( $_POST['update-s']))
                {
                    $errors     = array();// $success[] = 'Added';
                    $sTitle     = str_replace( ' ', '-', $_POST['stitle']);
                    $sCon       = $_POST['code'];
                    if (substr(trim($sCon), 0, 5) == '<?php') {
                    } else {
                        $sCon = '<?php ?>' . $sCon;
                    }
                    $sShortCode = '[ucsi snippet="'.$sTitle.'"]';
                    $sStatus    = 1;
                    $sDate      = date( get_option( 'date_format' ) . " h:i:s A");
                    if( !isset( $_POST['_wpnonce']) || !wp_verify_nonce( $_POST['_wpnonce'], '_ucsi'))
                    {
                        wp_nonce_ays( '_ucsi');
                        $errors[] = 'Bad Request';
                        exit();
                    }
                    if( !current_user_can( 'manage_options'))
                    {
                        $errors[] = 'Are you cheating?';
                    }
                    $sCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM $udci_tbl_c WHERE id != %d AND title=%s", $sID, $sTitle));
                    
                    if( $sCount > 0)
                    {
                        $errors[] = 'Snippet title already exists!';
                    }
                    if( empty( $_POST['stitle']))
                    {
                        $errors[] = 'Snippet title is required!';
                    }
                    if( empty( $errors)) 
                    {
                        // echo $sCon;
                        $wpdb->update(
                            $udci_tbl_c,
                            array(
                                'title'      => $sTitle,
                                'content'    => $sCon,
                                'updated_on' => $sDate,
                            ),
                            array( 
                                'id' => $sID
                            )
                        );
                        wp_redirect( admin_url( 'admin.php?page=uc-snippet' ));
                        exit();
                    }

                }
                require_once $this->pluginPath . 'templates/Admin/edit.php';
                break;
            case 'del':
                if( isset( $_GET['id']))
                {
                    $sID = intval( $_GET['id']);
                    if( !isset( $_GET['_wpnonce']) || !wp_verify_nonce( $_GET['_wpnonce'], '_ucsi-del-'. $sID))
                    {
                        wp_nonce_ays( '_ucsi-del-'. $sID);
                        wp_die( 'Error! xD');
                    }
                    $sCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM $udci_tbl_c WHERE id = %d", $sID));
                    
                    if( $sCount > 0)
                    {
                        //$sDel = $wpdb->query( $wpdb->prepare( "DELETE FROM $udci_tbl_c WHERE id = %d", $sID));
                        ucsi_delete_snippet( $sID);
                        wp_redirect( admin_url( 'admin.php?page=uc-snippet' ));
                        exit();
                    }
                    else 
                    {
                        wp_die('No snippet founds!');
                    }
                }
                break;
            default:
                $snippets = $wpdb->get_results( "SELECT * FROM $udci_tbl_c ORDER BY id" );
                require_once $this->pluginPath . 'templates/Admin/ucsiHome.php';
                break;
        }
    }
    
    /**
     * Add New Snippet Page Index
     *
     * @return void
     */
    public function pageAdd() {
        global $wpdb;
        $udci_tbl_c = $wpdb->prefix .'ud_short_code';
    }

    /**
     * Register 
     *
     * @return void
     */
    public function register() {
        add_action( 'admin_menu', array( $this, 'addPage'));
    }
}