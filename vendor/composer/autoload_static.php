<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd35f26ed38e2e96140b5fa2ca4e35e4b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd35f26ed38e2e96140b5fa2ca4e35e4b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd35f26ed38e2e96140b5fa2ca4e35e4b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd35f26ed38e2e96140b5fa2ca4e35e4b::$classMap;

        }, null, ClassLoader::class);
    }
}
