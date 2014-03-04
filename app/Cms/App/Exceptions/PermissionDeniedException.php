<?php namespace Cms\App\Exceptions;

class PermissionDeniedException extends \Exception {

    public function __construct() {
        $this->message = Lang::get('strings.permission_denied');
    }

}
