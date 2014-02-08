<?php namespace Cms\App\Messages;

class FlashMessageFactory {

    public static function makeAlertMessage($message, $classes = []) {
        return self::makeMessage($message, array_merge(['alert'], $classes));
    }

    public static function makeMessage($message, $classes = []) {
        return new FlashMessage($message, array_merge(['msg'], $classes));
    }

    public static function makeSuccessMessage($message, $classes = []) {
        return self::makeMessage($message, array_merge(['suc'], $classes));
    }

    public static function makeWarningMessage($message, $classes = []) {
        return self::makeMessage($message, array_merge(['wrn']), $classes);
    }

}
