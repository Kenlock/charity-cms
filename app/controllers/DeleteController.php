<?php

use Illuminate\Http\RedirectResponse;

class DeleteController extends BaseController {

    /**
     * Delete a charity
     */
    public function deleteCharity($charity_id) {
        return $this->deleteItem(Charity::findOrFail($charity_id), 'charity');
    }

    /**
     * Delete a comment
     */
    public function deleteComment($comment_id) {
        return $this->deleteItem(Comment::findOrFail($comment_id), 'comments', Redirect::back());
    }

    /**
     * Delete a page
     */
    public function deletePage($page_id) {
        $page = Page::with('charity')
            ->findOrFail($page_id);
        $redirect = "c/dashboard/{$page->charity->name}";

        if ($page->charity->default_page_id == $page_id)
            return Redirect::to($redirect)
                ->with('message_error', Lang::get('page.cannot_delete_default_page'));

        return $this->deleteItem($page, 'page', $redirect);
    }





    private function deleteItem($item, $lang_file, $redirect = 'users/dashboard') {
        if (!$redirect instanceof RedirectResponse) {
            dd($redirect);
            $redirect = Redirect::to($redirect);
        }

        if (Auth::user()->canDelete($item)) {
            $item->delete();
        } else {
            return $redirect
                ->with('message_error', Lang::get('strings.permission_denied'));
        }

        return $redirect
            ->with('message_success', Lang::get("{$lang_file}.delete_success"));
    }

}
