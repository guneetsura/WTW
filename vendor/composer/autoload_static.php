<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb12c9f152331faaf08f31961cd2b952b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb12c9f152331faaf08f31961cd2b952b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb12c9f152331faaf08f31961cd2b952b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb12c9f152331faaf08f31961cd2b952b::$classMap;

        }, null, ClassLoader::class);
    }
}
