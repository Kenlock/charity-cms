<?php
use presenters\Presentable;

use Cms\App\Path;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * A Basic model which can be validated for creating and editing rows in the
 * database.
 * BaseModel also allows each model to have a Presenter associated with it, which
 * can be accessed via BaseModel@getPresenter
 * @author Aidan Grabe
 */
abstract class BaseModel extends Eloquent implements Presentable {

    /**
     * The fully qualified class name of the Presenter the model should use
     * @var string
     */
    protected $presenter = null;

    /**
     * The Presenter instance this model will use for presentation
     * @var presenters\Presenter
     */
    private $presenterInstance = null;

    /**
     * the rules this model should be validated against when creating a new
     * entry in the database
     * @var array
     */
    protected $rules = array();

    /**
     * the rules that will be used when updating records.
     * Note: this array gets merged with $rules.
     * Note: placholders can be used:
     *      :id:    gets replaced by the current instance's primary key value
     *      :same:  gets replaced by the current rule in $rules
     */
    protected $updateRules = array();

    /**
     * The model's Validator
     * @var Validator
     */
    protected $validator;

    /**
     * Get the model's presenter instance, if it doesn't exist, create a new
     *      one
     * @return presenters\Presenter
     */
    public function getPresenter() {
        return $this->presenterInstance == null
            ? $this->presenterInstance = new $this->presenter($this)
            : $this->presenterInstance;
    }

    /**
     * Get the models validation rules
     * @param string $type the type of validation rules to get
     *      valid types: 'update'
     * @return array the array of rules
     */
    public function getValidationRules($type = 'rules') {
        switch ($type) {
            case 'update':
                return $this->updateRules;
            break;
            default:
                return $this->rules;
            break;
        }
    }

    public function getUpdateRules() {
        // replace id placeholder with the actual id
        $rules = array();
        foreach ($this->updateRules as $name => $rule) {
            if (array_key_exists($name, $this->rules)) {
                $rule = str_replace(':same:',
                        $this->rules[$name], $rule);
                $rule = str_replace(':id:',
                        $this->{$this->primaryKey} . ',' . $this->primaryKey, $rule);
            }
            $rules[$name] = $rule;
        }
        return $rules;
    }

    /**
     * Get the model's validator instance
     * @return Validator
     */
    public function getValidator() {
        return $this->validator;
    }

    /**
     * Check if the current model passes validation rules
     * @return boolean true if valid, else false
     */
    public function isValid() {
        return $this->validator->passes();
    }

    /**
     * Save an image to the uploads directory only if it exists
     * @param UploadedFile $image optional. The image to save
     * @return string the new path to the image relative to the project's root
     *      directory
     */
    public function saveImage($image = null) {
        $path = $image;
        if ($image != null && $image instanceof UploadedFile) {
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

    /**
     * Validate the current instance against $this->rules
     * @param array $data the data to validate against
     */
    public function validate($data) {
        $this->fill($data);
        $this->validator = Validator::make($data, $this->rules);
    }

    /**
     * Validate the current instance against $this->updateRules
     * @param array $data the data to validate against
     */
    public function validateUpdate($data) {
        $this->validator = Validator::make($data,
                array_merge($this->rules, $this->getUpdateRules()));

        $this->fill($data);
    }

}
