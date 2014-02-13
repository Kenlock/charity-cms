<?php

class CharityController extends BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', ['on' => 'post']);
        $this->beforeFilter('auth', array(
            'only' => array(
                'getCreate',
                'postCreate'
            )
        ));
    }

    public function getAll() {
        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.all');
        $layout->content->charities = Charity::get();
        return $layout;
    }

    public function getCreate() {
        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.create');
        return $layout;
    }

    public function getCharity($name) {
        $charity = Charity::where('name', '=', $name)->get()->first();
        dd($charity);
    }

    public function postCreate() {
        $validator = Charity::validate(Input::all());
        if ($validator->passes()) {
            $charity = Charity::make(Input::all());
            $charity->save();
            return Redirect::to('users/dashboard')
                ->with('message_success', "Charity {$charity->name} created successfully");
        } else {
            return Redirect::to('c/create')
                ->with('message', 'The Following errors occurred')
                ->withErrors($validator)
                ->withInput();
        }
    }

}
