<?php namespace observers;

class PageObserver {

    /**
     * Delete the Page's data
     * @param Page $page the page that's being deleted
     */
    public function deleting($page) {
        $page->posts()->get()->each(function($post) {
            $post->delete();
        });
    }

}
