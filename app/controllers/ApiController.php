<?php

class ApiController extends BaseController {
    protected $models = array(
        'User', 'Charity'
    );

    /**
     * Validate a field for a particular model
     * @return string JSON object containing 
     */
    public function validation($model, $field) {
        $data = array(
            'messages'  => '',
            'success'   => 'false',
            'valid'     => 'false'
        );
        if (in_array($model, $this->models)) {
            if (Input::has('id')) {
                $instance = $model::findOrFail(Input::get('id'));
                $rules = array_merge($instance->getValidationRules(),
                    $instance->getUpdateRules());
            } else {
                $instance = new $model;
                $rules = $instance->getValidationRules();
            }
            if (array_key_exists($field, $rules)) {
                $validator = Validator::make(array(
                    $field => Input::get('field')),
                    array($field => $rules[$field]));
                $passes = $validator->passes();

                $data['messages']   = $validator->errors()->toJson();
                $data['success']    = true;
                $data['valid']      = $passes;

            }
        }
        $response = Response::make(json_encode($data));
        $response->header('Content-Type', 'application/json');
        return $response;
       # $response = Response::make(json_decode($data));
       # $response->header('Content-Type', 'json');
       # return $response;
    }

}
