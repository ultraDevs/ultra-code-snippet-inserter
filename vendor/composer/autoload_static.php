<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited778d21f4dbd94269b0583ffe16e349
{
    public static $files = array (
        '8ec7fe9de4fae9d251965f120f205f4e' => __DIR__ . '/../..' . '/inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited778d21f4dbd94269b0583ffe16e349::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited778d21f4dbd94269b0583ffe16e349::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}