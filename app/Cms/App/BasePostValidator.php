<?php namespace Cms\App;

#use Illuminate\Validation\Validator;

abstract class BasePostValidator {

    protected $properties = array(
        array('small' => array(), 'large' => array())
    );

    protected $rules = array();

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
                    'content' => \Input::get($property)
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

            $data = \Input::all();
            $data[$name] = Path::make($path, $image->getClientOriginalName());
            \Input::replace($data);
        } else {
            \Input::merge(array(
                $name => ''
            ));
        }
    }

    public function validate($data = null) {
        $data = isset($data) ? $data : Input::all();
        $this->rules['title'] = 'required|between:2,255';
        return \Validator::make(\Input::all(), $this->rules);
    }

}
