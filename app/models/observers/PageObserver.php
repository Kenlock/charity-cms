<?php namespace observers;

use \Auth;
use \DB;
use \Permission;

class PageObserver {

    /**
     * Called when the instance is being created in the database
     * We want to begin a transaction for multiple inserts, in case of roll-back
     * @param Page $page the page being created
     */
    public function creating($page) {
        DB::beginTransaction();
    }

    /**
     * Called when the instance has been successfully inserted into the database
     * Here we want to create relevant permissions for the user
     * @param Page $page the page being created
     */
    public function created($page) {
        // create a new permission for the user
        $perm = new Permission();
        $perm->fill(array(
            'user_id'   => Auth::user()->user_id,
            'charity_id'=> $page->charity->charity_id,
            'page_id'   => $page->page_id,
            'level'     => Permission::CAN_EDIT_PAGE,
        ));
        $perm->save();

        // finally commit all changes to the DB
        DB::commit();
    }

    /**
     * Delete the Page's data
     * @param Page $page the page that's being deleted
     */
    public function deleting($page) {
        // delete this page's posts
        $page->posts()->get()->each(function($post) {
            $post->delete();
        });

        // delete permissions relating to this page
        $page->permissions()->get()->each(function($perm) {
            $perm->delete();
        });
    }

}
