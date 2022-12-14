<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0ca5c456778ce40a2cd95eee339d3ebb
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Csesumonpro\\PhpZipMaker\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Csesumonpro\\PhpZipMaker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0ca5c456778ce40a2cd95eee339d3ebb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0ca5c456778ce40a2cd95eee339d3ebb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0ca5c456778ce40a2cd95eee339d3ebb::$classMap;

        }, null, ClassLoader::class);
    }
}
