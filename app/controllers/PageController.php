<?php

class PageController extends BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array(
            'only' => array(
                'getCreate',
                'postCreate'
            )
        ));
    }

    private function charityExistsOrRedirect($charity) {
        if ($charity == null)
            return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('charity.charity_not_found'));
    }

    private function userCanCreateOrRedirect(Charity $charity) {
        if (!Auth::user()->canCreatePage($charity))
            return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('charity.deny_create_page'));
    }

    public function getCreate($charity_id) {
        // check if the charity exists
        $charity = Charity::find($charity_id);

        $this->charityExistsOrRedirect($charity);
        $this->userCanCreateOrRedirect($charity);
        
        // show the form
        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.page_create', array(
            'charity' => $charity
        ));
        return $layout;
    }

    public function postCreate($charity_id) {
        // check if the charity exists
        $charity = Charity::find($charity_id);

        $this->charityExistsOrRedirect($charity);
        $this->userCanCreateOrRedirect($charity);

        Input::merge(array(
            'charity_id' => $charity_id
        ));
        $validator = Page::validate(Input::all());

        if ($validator->passes()) {
            $page = Page::makeAndSave(Auth::user(), $charity, Input::all());

            return Redirect::to("c/dashboard/{$charity->name}")
                ->with('message_success', Lang::get('forms.page_created', array(
                    'page_title' => $page->title
                )));
        } else {
            return Redirect::to("pages/create/{$charity_id}")
                ->with('message_error', Lang::get('form.errors_occurred'))
                ->withErrors($validator)
                ->withInput();
        }
    }

}
