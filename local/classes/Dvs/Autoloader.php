<?php

namespace Dvs;

class Autoloader {

    public static function run() {
        spl_autoload_register(__CLASS__ . '::loadClass');
    }

    public static function loadClass($class) {
        $pieces = explode('\\', $class);
        if ($pieces[0] === 'Dvs') {
            $file = static::createFilePath($pieces);
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        }
    }

    private function createFilePath($pieces) {
        $pieces[0] = __DIR__;
        $path = implode('/', $pieces);
        return $path . ".php";
    }

}
