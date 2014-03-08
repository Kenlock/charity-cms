<?php namespace presenters;

use \Markdown;

/**
 * Class used to present the Charity Model to users
 * @author Aidan Grabe
 */
class CharityPresenter extends BasePresenter {
    const DEFAULT_IMAGE = 'css/images/user_default.png';

    /**
     * Display the address line by line
     * @return string
     */
    public function getAddressAttribute() {
        return str_replace(',', '<br />', $this->item->address);
    }

    /**
     * Get the charity's description as HTML instead of Markdown
     * @return string
     */
    public function getDescriptionAttribute() {
        return Markdown::string($this->item->description);
    }

    /**
     * get the charity's image, if it is blank, then return the default
     * @return string the relative URL to the charity's image
     */
    public function getImageAttribute() {
        return $this->item->image == ''
            ? self::DEFAULT_IMAGE
            : $this->item->image;
    }

}
