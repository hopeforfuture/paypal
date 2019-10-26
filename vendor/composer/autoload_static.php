<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb4afa6e5673a4e8f76af7fab45e3a5aa
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb4afa6e5673a4e8f76af7fab45e3a5aa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb4afa6e5673a4e8f76af7fab45e3a5aa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}