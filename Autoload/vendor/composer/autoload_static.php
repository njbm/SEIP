<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2ec8b7ac60669f57a0776d013e1fcc34
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jaber\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jaber\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2ec8b7ac60669f57a0776d013e1fcc34::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2ec8b7ac60669f57a0776d013e1fcc34::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2ec8b7ac60669f57a0776d013e1fcc34::$classMap;

        }, null, ClassLoader::class);
    }
}
