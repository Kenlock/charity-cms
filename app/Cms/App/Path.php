<?php namespace Cms\App;

class Path {

    public static function make() {
        $args = func_get_args();
        $first = in_array($args[0][0], array('/', '\\')) ? DIRECTORY_SEPARATOR : '';
        $path = '';
        foreach ($args as $arg) {
            $dirs = preg_split('/(\/|\\\)/', $arg);
            $path[] = implode(DIRECTORY_SEPARATOR, array_filter($dirs));
        }
        return $first . implode(DIRECTORY_SEPARATOR, $path);
    }

}
