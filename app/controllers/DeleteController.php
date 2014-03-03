<?php

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
        return $this->deleteItem(Comment::findOrFail($comment_id), 'comments');
    }

    /**
     * Delete a page
     */
    public function deletePage($page_id) {
        $page = Page::with('charity')
            ->findOrFail($page_id);

        if ($page->charity->default_page_id == $page_id)
            return Redirect::to("c/dashboard/{$page->charity->name}")
                ->with('message_error', Lang::get('page.cannot_delete_default_page'));

        return $this->deleteItem($page, 'page');
    }





    private function deleteItem($item, $lang_file) {
        if (Auth::user()->canDelete($item)) {
            $item->delete();
        } else {
            return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('strings.permission_denied'));
        }

        return Redirect::to('users/dashboard')
            ->with('message_success', Lang::get("{$lang_file}.delete_success"));
    }

}
