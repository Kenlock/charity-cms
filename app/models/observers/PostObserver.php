<?php namespace observers;

class PostObserver {

    /**
     * Delete the post's data
     * @param Post $post the post that's being deleted
     */
    public function deleting($post) {
        $post->comments()->get()->each(function($comment) {
            $comment->delete();
        });
    }

}
