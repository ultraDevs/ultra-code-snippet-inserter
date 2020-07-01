<?php

defined('ABSPATH') || die();

/** 
 * Delete a Snippet 
 * 
 * @param int $id
 * 
 * @return int|boolean
 */
function ucsi_delete_snippet( $id) {
    global $wpdb;
    $udci_tbl_c = $wpdb->prefix .'ud_short_code';
    return $wpdb->query( $wpdb->prepare( "DELETE FROM $udci_tbl_c WHERE id = %d", $id));
}

/**
 * Status
 * 
 * @param int $code
 * 
 * @return string
 */
function getStatus( $code) {
    if ( $code == 1) {
        return "<b style=\"color: green;\">Active</b>";
    }
    else {
        return "<b style=\"color: red;\">Inactive</b>";
    }
}
