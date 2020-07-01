<?php
/**
 * @package ultraCodeSnippetInserter
 */

namespace Inc;

defined('ABSPATH') || die();

/**
 * Init Class
 */
final class Init
{
    /**
     * Return all classes as array
     *
     * @return array list of classes
     */
    public static function getClasses() {
        return array(
            Base\Enqueue::class,
            Base\ShortCodeHandler::class,
            Pages\Dashboard::class,
        );
    }
    /**
     * get all class, initialize them, call register method if exists
     *
     * @return 
     */
    public static function registerServices() {
        foreach ( self::getClasses() as $class) {
            $services = self::initClass( $class);
            if( method_exists( $services, 'register') ) {
                $services->register();
            }
        }
    }
    /**
     * Initialize the class
     *
     * @param class $class classes from the array
     * 
     * @return class instance new instance of the class
     */
    public static function initClass( $class) {
        return new $class;
    }
}