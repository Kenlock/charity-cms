<?php namespace Cms\App\Validators;

use User;
use Validator;

/**
 * Validator Service for deleting a User
 * @author Aidan Grabe
 */
class UserDeleteValidator {

    protected $data;
    protected $rules = array(
        'confirm_delete'    => 'required|accepted'
    );
    protected $validator;

    /**
     * 
     * @param array $data the data under validation
     * @param Validator $validator optional. the validator to carry out the
     *      validation
     */
    public function __construct($data, Validator $validator = null) {
        $this->data = $data;
        $this->validator = $validator == null
            ? Validator::make($data, $this->rules)
            : $validator;
    }

    /**
     * Check if the alidation passes
     * @return boolean true if the data is valid, else false
     */
    public function passes() {
        $this->validator->setData($this->data);
        return $this->validator->passes();
    }

    /**
     * Get the validator instance
     * @return Validator
     */
    public function getValidator() {
        return $this->validator;
    }

}
