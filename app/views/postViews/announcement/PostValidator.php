<?php

use Cms\App\BasePostValidator;
use Cms\App\Sanitiser;

class PostValidator extends BasePostValidator {

    protected $properties = array(
        'small' => array(
            'animal_name',
            'contact',
            'image'
        ),
        'large' => array(
            'animal_description',
        )
    );

    protected $rules = array(
        'animal_name'   => 'required|between:2,100',
        'contact'       => 'required|between:2,255',
        'animal_description'     => 'required',
        'image'         => 'image|max:4096'
    );

    public function onSuccess() {
        $this->saveImage('image');

        return parent::onSuccess();
    }

    public function validate($data = null) {
        $sanitiser = Sanitiser::make(\Input::all())
            ->guard('image')
            ->sanitise();
        return parent::validate($sanitiser->all());
    }

}
