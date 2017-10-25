<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitccf32acffed5ec49ad2d4746ef8f3ca5
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpXmlRpc\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpXmlRpc\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpxmlrpc/phpxmlrpc/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/klarna/php-xmlrpc/src',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitccf32acffed5ec49ad2d4746ef8f3ca5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitccf32acffed5ec49ad2d4746ef8f3ca5::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInitccf32acffed5ec49ad2d4746ef8f3ca5::$fallbackDirsPsr4;

        }, null, ClassLoader::class);
    }
}