<?php 
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc\Base;

defined('ABSPATH') || die();

/**
 * Class for handling all shortcodes
 */
class ShortCodeHandler extends BaseController
{
    /**
     * Add Shortcode
     */
    public function shortCodesContent( $scParam) {
        global $wpdb;
        $snippet = $scParam['snippet'];
        $ucsTbl  = $wpdb->prefix . 'ud_short_code';
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $ucsTbl WHERE title=%s", $snippet));

        if( count( $results) > 0) {
            foreach( $results as $result) {
                if( $result->status == 1) {
                    ob_start();
                    $output = $result->content;
                    if( substr( trim( $output), 0, 5) == '<?php' )
                    {
                        $output = '?>' . $output;
                    }
                    eval( $output);
                    $finalOutput = ob_get_contents();
                    ob_end_clean();
                    return $finalOutput;
                }
            break;
            }
        }
    }

    /**
     * Register Method
     */
    public function register() {
        add_shortcode( 'ucsi', array( $this, 'shortCodesContent') );
        add_filter( 'widget_text', 'do_shortcode');
    }
}