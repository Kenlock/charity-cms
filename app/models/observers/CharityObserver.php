<?php namespace observers;

class CharityObserver {

    /**
     * Delete the Charity's data
     * @param Charity $charity the charity that's being deleted
     */
    public function deleting($charity) {
        $charity->pages()->delete();
        $charity->permissions()->delete();
    }

}
