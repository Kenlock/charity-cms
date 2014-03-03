<?php namespace presenters;

class UserPresenter extends BasePresenter {
    const DEFAULT_IMAGE = 'css/images/user_default.png';

    public function __construct(Presentable $item) {
        parent::__construct($item);
    }

    public function getDescriptionAttribute() {
        return \Markdown::string($this->item->description);
    }

    public function getImageAttribute() {
        return $this->item->image == ''
            ? self::DEFAULT_IMAGE
            : $this->item->image;
    }

    public function getName() {
        return $this->item->firstname . " " . $this->item->lastname;
    }


}
