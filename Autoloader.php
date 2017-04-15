<?php

/**
 * Class Autoloader
 * @author  Hamza ESSAYEGH <hamza.essayegh@protonmail.com>
 */
class Autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class)
    {
        require 'lib/' . $class . '.php';
    }
}