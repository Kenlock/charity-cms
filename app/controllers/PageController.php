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

    public function getCreate($charity_id) {
        // check if the charity exists
        $charity = Charity::find($charity_id);
        if ($charity == null) return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('charity.charity_not_found'));
        
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
        if ($charity == null) return Redirect::to('users/dashboard')
                ->with('message_error', Lang::get('charity.charity_not_found'));

        Input::merge(array(
            'charity_id' => $charity_id
        ));
        $validator = Page::validate(Input::all());

        if ($validator->passes()) {
            $page = new Page();
            $page->fill(Input::all());
            DB::beginTransaction();
            $page->page_id = $page->save();
            $perm = Permission::make(Auth::user(), Charity::find($charity_id), $page, 1);
            $perm->save();
            DB::commit();

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
