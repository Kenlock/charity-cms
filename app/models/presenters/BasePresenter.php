<?php namespace presenters;

abstract class BasePresenter {

    protected $item;

    public function __construct(Presentable $item) {
        $this->item = $item;
    }

    public function __get($name) {
        $methodName = camel_case("get_{$name}_attribute");
        if (method_exists($this, $methodName)) {
            return call_user_func(array($this, $methodName));
        }
        return $this->item->$name;
    }

    public function getPresentable() {
        return $this->item;
    }

}
