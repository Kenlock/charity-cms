<?php namespace Cms\App;

use Illuminate\Database\Eloquent\Collection;

class Styles {
    private $collection;
    private $properties;

    public function __construct(Collection $collection) {
        $this->collection = $collection;
        $this->properties = array();

        foreach ($this->collection as $item) {
            $this->properties[$item->property] = $item->value;
        }
    }

    public function get($selector, $rule, $name) {
        if (array_key_exists($name, $this->properties)) {
            return "{$selector} {{$rule}:{$this->properties[$name]};}";
        }
    }

    public function getProperty($name) {
        return array_key_exists($name, $this->properties)
            ? $this->properties[$name]
            : '';
    }

}
