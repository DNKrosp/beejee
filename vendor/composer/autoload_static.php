<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf258b3a92ce210e697a81646602e5191
{
    public static $files = array (
        '408aa5e5561507804509d317be5b80e3' => __DIR__ . '/../..' . '/paths.php',
    );

    public static $prefixLengthsPsr4 = array (
        'w' => 
        array (
            'web\\' => 4,
        ),
        'm' => 
        array (
            'model\\' => 6,
        ),
        'c' => 
        array (
            'core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'web\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/web',
        ),
        'model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/model',
        ),
        'core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf258b3a92ce210e697a81646602e5191::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf258b3a92ce210e697a81646602e5191::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf258b3a92ce210e697a81646602e5191::$classMap;

        }, null, ClassLoader::class);
    }
}
