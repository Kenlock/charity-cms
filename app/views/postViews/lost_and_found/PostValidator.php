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
            'last_seen',
            'extra_info'
        )
    );

    protected $rules = array(
        'animal_name'   => 'required|between:2,100',
        'contact'       => 'required|between:2,100',
        'last_seen'     => 'required|between:2,100',
        'extra_info'    => '',
        'image'         => 'required|image|max:4096'
    );

    protected $updateRules = array(
        'image'         => 'image|max:4096'
    );

    public function editing($post) {
        $this->data['image'] = $post->image;
    }

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
