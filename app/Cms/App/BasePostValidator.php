<?php namespace Cms\App;

#use Illuminate\Validation\Validator;

abstract class BasePostValidator {

    private $data;

    protected $properties = array(
        array('small' => array(), 'large' => array())
    );

    protected $rules = array();

    public function __construct() {
        $this->data = array();
    }

    public function onSuccess() {
        $fields = array_merge($this->properties['small'], $this->properties['large']);
        $insertData = array(
            'small' => array(),
            'large' => array()
        );

        foreach ($this->properties as $size => $properties) {
            foreach ($properties as $property) {
                $insertData[$size][] = array(
                    'title' => $property,
                    'content' => $this->data[$property]
                );
            }
        }

        return $insertData;
    }

    public function saveImage($name) {
        if (\Input::hasFile($name)) {
            $image = \Input::file($name);
            $date = date('d-m-Y');
            $path = Path::make("uploads", $date);
            $movePath = Path::make(public_path(), $path);
            $image->move($movePath, $image->getClientOriginalName());

            $this->data[$name] = Path::make($path, $image->getClientOriginalName());
        } else {
            \Input::merge(array(
                $name => ''
            ));
        }
    }

    /**
     * Validate the given data according to the posts rules
     */
    public function validate($data = null) {
        $this->data = isset($data) ? $data : Input::all();
        $this->rules['title'] = 'required|between:2,100';
        return \Validator::make($this->data, $this->rules);
    }

}
