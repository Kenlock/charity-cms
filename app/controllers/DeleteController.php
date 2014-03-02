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
