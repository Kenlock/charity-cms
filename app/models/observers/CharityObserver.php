<?php namespace observers;

class CharityObserver {

    /**
     * Delete the Charity's data
     * @param Charity $charity the charity that's being deleted
     */
    public function deleting($charity) {
        $charity->pages()->get()->each(function($charity) {
            $charity->delete();
        });
    }

    public function deleted($charity) {
        $charity->permissions()->delete();
    }

}
