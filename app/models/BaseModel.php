<?php

use Cms\App\Path;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseModel extends Eloquent {

    protected $rules = array();

    /**
     * the rules that will be used when updating records.
     * Note: this array gets merged with $rules.
     * Note: placholders can be used:
     *      :id:    gets replaced by the current instance's primary key value
     *      :same:  gets replaced by the current rule in $rules
     */
    protected $updateRules = array();

    protected $validator;

    public function getValidator() {
        return $this->validator;
    }

    public function isValid() {
        return $this->validator->passes();
    }

    public function saveImage($image = null) {
        $path = '';
        if ($image != null && $image instanceof UploadedFile) {
            $date = date('d-m-Y');
            $path = Path::make("uploads", $date);
            $newPath = Path::make(public_path(), $path);

            // move + rename file
            $image->move($newPath, $image->getClientOriginalName());

            // get the path relative to public folder
            $path = Path::make($path, $image->getClientOriginalName());
        } elseif ($image != null) {
            $path = $image;
        }
        return $path;
    }

    public function validate($data) {
        $this->validator = Validator::make($data, $this->rules);
        $this->fill($data);
    }

    public function validateUpdate($data) {
        // replace id placeholder with the actual id
        foreach ($this->updateRules as $name => $rule) {
            if (array_key_exists($name, $this->rules)) {
                $rule = str_replace(':same:',
                        $this->rules[$name], $rule);
                $this->updateRules[$name] = str_replace(':id:',
                        $this->{$this->primaryKey} . ',' . $this->primaryKey, $rule);
            }
        }
        $this->validator = Validator::make($data,
                array_merge($this->rules, $this->updateRules));

    }

}
