<?php

use Cms\App\Path;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseModel extends Eloquent {

    protected $rules = array();

    protected $validator;

    public function getValidator() {
        return $this->validator;
    }

    public function isValid() {
        return $this->validator->passes();
    }

    public function saveImage(UploadedFile $image = null) {
        $path = '';
        if ($image != null) {
            $date = date('d-m-Y');
            $path = Path::make("uploads", $date);
            $newPath = Path::make(public_path(), $path);

            // move + rename file
            $image->move($newPath, $image->getClientOriginalName());

            // get the path relative to public folder
            $path = Path::make($path, $image->getClientOriginalName());
        }
        return $path;
    }

    public function validate($data) {
        $this->validator = Validator::make($data, $this->rules);
        $this->fill($data);
    }

}
