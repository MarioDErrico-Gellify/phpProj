<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0cc4039380dbb20b1a4b243dae3472eb
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VatValidation\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VatValidation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
            1 => __DIR__ . '/..' . '/drahosistvan/vatvalidation/src/VatValidation',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0cc4039380dbb20b1a4b243dae3472eb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0cc4039380dbb20b1a4b243dae3472eb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0cc4039380dbb20b1a4b243dae3472eb::$classMap;

        }, null, ClassLoader::class);
    }
}