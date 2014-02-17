<?php namespace Cms\App;

class Sanitiser {
    private $data;
    private $guarded;

    public function __construct($data) {
        $this->data = $data;
        $this->guarded = array();
    }

    public function all() {
        return $this->data;
    }

    public function get($key) {
        return $this->data[$key];
    }

    public function getAll() {
        return $this->data;
    }

    public function guard($guard) {
        if (is_array($guard)) {
            $this->guarded = array_merge($this->guarded, $guard);
        } else {
            $this->guarded[] = $guard;
        }
        return $this;
    }

    public static function make($data) {
        return new Sanitiser($data);
    }

    public function merge(&$data) {
        $data = $this->data;
        return $this;
    }

    public function sanitise($only = array()) {
        if (count($only) == 0) $only = array_keys($this->data);
        foreach ($this->data as $key => $value) {
            if (in_array($key, $only) && !in_array($key, $this->guarded)) {
                $this->data[$key] = \e($this->data[$key]);
            }
        }
        return $this;
    }

}
