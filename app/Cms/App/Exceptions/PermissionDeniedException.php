<?php namespace Cms\App\Exceptions;

use \Lang;

/**
 * An exception which should be thrown when a given user attempts to complete
 * an action which she doesn't have permission to do
 * @author Aidan Grabe
 */
class PermissionDeniedException extends \Exception {

    /**
     * set the exceptions message to a lang file
     */
    public function __construct() {
        $this->message = Lang::get('strings.permission_denied');
    }

}
