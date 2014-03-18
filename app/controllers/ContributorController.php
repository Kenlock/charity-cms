<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Cms\App\Exceptions\PermissionDeniedException;

class ContributorController extends BaseController {

    /**
     * List the administrators for a given charity, and show a search form
     * to allow the user to add administrators.
     * This method can handle both GET and POST requests
     * @param string $charity_name the name of the charity to show admins for
     * @param int $page_id optional the page to show admins for
     */
    public function getContributors($charity_name, $page_id = 0) {
        $charity = Charity::where('name', '=', $charity_name)
            ->firstOrFail();
        if ($charity == null) {
            $exception = new ModelNotFoundException();
            $exception->setModel('Charity');
            throw $exception;
        }

        // fail if the user is not an admin of this charity
        if (!Auth::user()->isAdmin($charity))
            throw new PermissionDeniedException();

        // get the page if possible
        $page = $charity->pages()
            ->where('page_id', '=', $page_id)
            ->first();

        // get admins/constributors for this charity/page
        $contributors = $page == null
            ? $charity->getAdmins()
            : $page->getContributors();

        // get the search results
        $search_results = Input::has('user_name')
            ? User::searchByName(Input::get('user_name'))
            : array();

        // append input to the pagination URL
        if (count($search_results) > 0) {
            $search_results->appends(array('user_name' => Input::get('user_name')));
        }

        return View::make('layout._single_column', array(
            'content' => View::make('contributors.view', array(
                'contributors'  => $contributors,
                'charity'       => $charity,
                'query'         => Input::get('user_name'),
                'search_results'=> $search_results,
                'type'          => $page == null ? 'Admins' : null
            )),
        ));
    }

    /**
     * Remove an admin from a given charity
     * @param int $charity_id the id of the charity to remove the admin from
     * @param int $user_id the id of the user to remove the privileges
     * @return Redirect
     */
    public function getDelete($charity_id, $user_id) {
        $user = User::findOrFail($user_id);
        $charity = Charity::findOrFail($charity_id);

        if (!Auth::user()->isAdmin($charity)) App::abort(403, "Permission Denied");

        if ($charity->getAdmins()->count() > 1) {
            $user->removeAdmin($charity);
        } else {
            return Redirect::back()
                ->with('message_error', 'You must have at least 1 admin for a charity');
        }

        return Redirect::back()
            ->with('message_success', 'Admin removed');
    }

}
