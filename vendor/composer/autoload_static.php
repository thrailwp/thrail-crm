<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit63a9b74521f0268907fcb5cf526d2590
{
    public static $files = array (
        'd60e5f2be18e10a551e2c27df74050c3' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Thrail\\Crm\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Thrail\\Crm\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit63a9b74521f0268907fcb5cf526d2590::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit63a9b74521f0268907fcb5cf526d2590::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit63a9b74521f0268907fcb5cf526d2590::$classMap;

        }, null, ClassLoader::class);
    }
}
