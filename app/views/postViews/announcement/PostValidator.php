<?php

use Cms\App\BasePostValidator;
use Cms\App\Sanitiser;

class PostValidator extends BasePostValidator {

    protected $properties = array(
        'small' => array(
        ),
        'large' => array(
            'content',
        )
    );

    protected $rules = array(
        'content'   => 'required',
    );

    #public function onSuccess() {
    #    $this->saveImage('image');

    #    return parent::onSuccess();
    #}

    public function validate($data = null) {
        $sanitiser = Sanitiser::make(\Input::all())
            ->sanitise();
        return parent::validate($sanitiser->all());
    }

}
