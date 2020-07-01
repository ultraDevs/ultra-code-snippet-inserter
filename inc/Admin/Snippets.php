<?php
/**
 * @package ultraCodeSnippetInserter
 */
namespace Inc\Admin;

defined('ABSPATH') || die();

if ( !class_exists( 'WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
/**
 * Snippet Class
 */
class Snippets extends \WP_List_Table {

    public function __construct() {
        parent::__construct( array(
            'singular' => __( 'Snippet', 'ucsi'),
            'plural' => __( 'Snippets', 'ucsi'),
            'ajax' => false,
        ));
    }

    /**
     * Retrieve Snippets from the database
     * 
     * @param int $per_page
     * @param int $page_number
     * 
     * @return mixed
     */
    public function get_snippets( $per_page = 10, $page_number = 1) {
        
        global $wpdb;
        $udci_tbl_c = $wpdb->prefix .'ud_short_code';

        $search = (isset($_REQUEST['s'])) ? sanitize_text_field( $_REQUEST['s']) : false;
        
        $do_search = ($search) ? "WHERE title LIKE '%$search%' OR short_code LIKE '%$search%'" : '';

        $sQuery = "SELECT * FROM $udci_tbl_c $do_search";

        if( !empty( $_REQUEST['orderby'])) {
            $sQuery .= " ORDER BY " . esc_sql( $_REQUEST['orderby']);
            $sQuery .= !empty( $_REQUEST['order']) ? ' ' . esc_sql( $_REQUEST['order']) : ' ASC';
        }
        $sQuery .= " LIMIT $per_page";
        $sQuery .= " OFFSET " . ( $page_number - 1) * $per_page;
        $snippets = $wpdb->get_results( $sQuery);

        return $snippets;
    }

    /**
     * No Items
     * 
     * @return void
     */
    public function no_items() {
        _e( 'No snippets found!', 'ucsi');
    }

    /**
     * Get the column Name
     * 
     * @return array
     */
    public function get_columns() {
        return array(
            'cb' => '<input type="checkbox" />',
            'name' => __( 'Snippet Title', 'ucsi'),
            'short_code' => __( 'Shortcode', 'ucsi'),
            'created_at' => __( 'Created at', 'ucsi'),
            'updated_on' => __( 'Updated on', 'ucsi'),
            'status' => __( 'Status', 'ucsi'),
        );
    }

    /**
     * Get Sortable Columns
     * 
     * @return array
     */
    public function get_sortable_columns() {
        $sortableColumns = array(
            'name' => array( 'title', true),
            'short_code' => array( 'short_code', true),
            'created_at' => array( 'created_at', true),
            'updated_on' => array( 'updated_on', true),
        );
        return $sortableColumns;
    }

    /**
     * Set Bulk Actions
     * 
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            'bulk-delete' => __( 'Delete', 'ucsi'),
        );
        return $actions;
    }

    /**
     * Snippet Counter
     * 
     * @return int
     */
    public static function ucsi_snippets_count() {
        global $wpdb;
        return (int) $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}ud_short_code");
    }

    /**
     * Render the Name Column
     * 
     * @param object $item 
     * 
     * @return string
     */
    public function column_name( $item) {
        $actions = array();
        $title = '<strong><a href="'.admin_url('admin.php?page=uc-snippet&action=edit&id='. $item->id ).'">' . $item->title . '</a></strong>';
        $delUrl = admin_url( 'admin.php?page=uc-snippet&action=del&id='. $item->id );
        $actions['edit'] = sprintf('<a href="%s" title="%s">%s</a>', admin_url('admin.php?page=uc-snippet&action=edit&id='. $item->id ), $item->id, __( 'Edit', 'ucsi'));
        $actions['delete'] = sprintf('<a href="%s" title="%s" onclick="javascript: return confirm( \'Are you sure?\' ); ">%s</a>', wp_nonce_url( $delUrl, '_ucsi-del-'. $item->id), $item->id, __( 'Delete', 'ucsi'));

        return $title . $this->row_actions( $actions);
    }   

    /**
     * Render the column cb
     * 
     * @return string
     */
    public function column_cb( $item) {
        return sprintf( 
            '<input type="checkbox" name="bulk-delete[]" value="%s">', $item->id
        );
    }

    /**
     * Default Column Values
     * 
     * @param object $item
     * @param string $column_name
     * 
     * @return string 
     */
    public function column_default( $item, $column_name) {

        switch( $column_name)
        {
            case 'status':
                return getStatus( $item->status);
                break;
            default:
                return isset( $item->$column_name) ? $item->$column_name : '';  
        }
    }

    /**
     * Bulk Actions
     * 
     * @return mixed
     */
    public function process_bulk_action() {
        global $wpdb;
        /** 
         * Bulk Delete
         */
        if( isset( $_POST['action']) && $_POST['action'] == 'bulk-delete')
        {
            $dIDs = esc_sql( $_POST['bulk-delete']);
            foreach( $dIDs as $dID)
            {
                $udci_tbl_c = $wpdb->prefix .'ud_short_code';
                ucsi_delete_snippet( $dID);
                wp_redirect( admin_url( 'admin.php?page=uc-snippet' ));
            }
        }
    }

    /**
     * Prepare the snippet items
     * 
     * @return void
     */
    public function prepare_items() {

        $column = $this->get_columns();

        /** Process Bulk Action */
        $this->process_bulk_action();

        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $column, array(), $sortable);
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = self::ucsi_snippets_count();

        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page' => $per_page,
        ));
        $this->items = $this->get_snippets( $per_page, $current_page);
    }
}

