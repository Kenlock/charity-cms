<?php namespace Cms\App;

class LocalisedStringNotFoundException extends \Exception {
    public function __construct($key, $locale) {
        $message = "The string: '{$key}' was not found for locale '{$locale}',"
                    . " and no string was found in the default locale.";
        parent::__construct($message);
    }
}

/**
 * @author Aidan Grabe
 * Strings class is used for localising text. Set your pre-defined strings
 * here, and set the locale. The system will then output the correct language
 * when Strings::get() is called.
 */
class Strings {
    private static $defaultLocale = 'en';
    private static $locale = 'en';
    
    private static $strings_en = array(
        'login_failed' => 'The email address/password entered did not match any of records',
        'login_required' => 'You must login to see this page',
        'login_successful' => 'Login Successful',
        'register_error' => 'The following errors occurred.',
        'register_success' => 'Your account was successfully created. Thank you for registering with us.'
    );

    private static $strings_fr = array(
        'register_success' => 'Merci pour avoir enregistre avec nous.'
    );
   
   /**
    * @throws LocalisedStringNotFoundException when the key is not found for
    *       the given locale, nor the default locale.
    * @param String $key the name of the string to return
    * @param String $locale optional. the locale to use. Must have a static
    *       array called $strings_<locale> to match
    * @return String the localised version of a string 
    */
    public static function get($key, $locale = null) {
        $locale = $locale == null ? self::$locale : $locale;
        $varName = "strings_{$locale}";
        if (array_key_exists($key, self::$$varName)) {
            return self::${$varName}[$key];
        } else {
            $varName = "strings_" . self::$defaultLocale;
            if (array_key_exists($key, self::$$varName)) {
                return self::${$varName}[$key];
            } else {
                throw new LocalisedStringNotFoundException($key, $locale);
            }
        }
    }
   
   /**
    * Set the locale of the system
    * @param String $locale the locale to use
    */
    public function setLocale($locale) {
        self::$locale = $locale;
    }

}
