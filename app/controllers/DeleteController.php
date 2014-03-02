<?php

class DeleteController extends BaseController {

    public function __construct() {
        $this->beforeFilter('auth', array(
            'only' => array(
                'deleteCharity',
            )
        ));
    }

    /**
     * Delete a charity
     */
    public function deleteCharity($charity_id) {
        try {
            $charity = Charity::findOrFail($charity_id);
        } catch (Exception $e) {
            dd($e);
        }

        if (Auth::user()->canDelete($charity)) {
            $charity->delete();
        } else {
            Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('strings.permission_denied'));
        }

        return Redirect::to('users/dashboard')
            ->with('message_success', Lang::get('charity.delete_success'));
    }

}
