<?php namespace observers;

use \Auth;
use \DB;
use \Page;
use \Permission;

/**
 * Observer for Charity model events
 * @author Aidan Grabe
 */
class CharityObserver {

    /**
     * Method called when a Charity is being created in the database
     * @param Charity $charity the charity model instance being created
     */
    public function creating($charity) {
        DB::beginTransaction();
    }

    /**
     * Called when a new charity has been inserted into the database.
     * Create the necessary permissions and default page for the charity
     * @param Charity the charity that has been created
     */
    public function created($charity) {
        $permission = Permission::make(Auth::user(), $charity, Permission::ALL_PAGES, 1);
        $permission->save();

        // create the default page
        $page = new Page();
        $page->fill(array(
            'charity_id' => $charity->charity_id,
            'title' => "Home",
            'default_view_id' => Page::DEFAULT_POSTVIEW,
        ));
        $page->save();
    
        // update the charity's settings
        $charity->default_page_id = $page->page_id;
        $charity->update();
        
        DB::commit();
    }

    /**
     * Delete the Charity's data
     * @param Charity $charity the charity that's being deleted
     */
    public function deleting($charity) {
        $charity->pages()->get()->each(function($charity) {
            $charity->delete();
        });
        $charity->socialLinks()->delete();
    }

    /**
     * Method called when the charity has been deleted
     * Remove all permissions belonging to this charity
     */
    public function deleted($charity) {
        $charity->permissions()->delete();
    }

    public function saving($charity) {
        $charity->image = $charity->saveImage($charity->image);
    }

}
