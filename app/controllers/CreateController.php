<?php

use Cms\App\Exceptions\PermissionDeniedException;

class CreateController extends BaseController {

    /**
     * Add an administrator to a charity
     * @param int $charity_id the charity's id to add the administrator to
     * @param int $user_id the user to give admin priveleges to
     * @return Redirect
     */
    public function createAdmin($charity_id, $user_id) {
        $charity = Charity::findOrFail($charity_id);
        $user = User::findOrFail($user_id);

        // check current user's permissions
        if (!Auth::user()->isAdmin($charity))
            throw new PermissionDeniedException();


        if (Permission::where('user_id', '=', $user_id)
                ->where('charity_id', '=', $charity_id)
                ->count() > 0)
            return Redirect::back()
                ->with('message_error', Lang::get('contributors.admin_exists'));

        // create the permission
        Permission::make($user, $charity, Permission::ALL_PAGES, Permission::CAN_POST)
            ->save();

        return Redirect::back()
            ->with('message_success', Lang::get('contributors.created_admin'));
    }

    /**
     * Create the permissions to allow a user to post to a certain page
     * @param int $charity_id the charity's id
     * @param int $user_id the user to give admin priveleges to
     * @return Redirect
     */
    public function createPageContributor($page_id, $user_id) {
        $page = Page::findOrFail($page_id);
        $user = User::findOrFail($user_id);

        // check current user's permissions
        if (!Auth::user()->isAdmin($page->charity))
            throw new PermissionDeniedException();
        
        // create the permission
        Permission::make($user, $page->charity, $page, Permission::CAN_POST)
            ->save();

        return Redirect::action('Charity@getDashboard', $page->charity->name)
            ->with('message_success', 'Contributor Added Successfully');
    }

}
