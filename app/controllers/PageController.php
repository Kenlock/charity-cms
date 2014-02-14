<?php

class PageController extends BaseController {

    public function getCreate($charity_id) {
        $charity = Charity::find($charity_id);
        if ($charity == null) return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('charity.charity_not_found'));
        
    }

    public function postCreate() {
        
    }

}
