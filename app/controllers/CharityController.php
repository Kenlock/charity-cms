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

        $layout = View::make('layout._two_column');
        $layout->sidebar = "Sidebar";
        $layout->content = View::make('charity.view');
        $layout->content->charity = $charity;
        return $layout;
    }

    public function getDashboard($name) {
        $charity = Charity::where('name', '=', $name)->first();
        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.dashboard');
        $layout->content->charity = $charity;
        return $layout;
    }

    public function postCreate() {
        $address = implode(',', array(Input::get('address'), Input::get('address1'), Input::get('address2')));
        $validator = Charity::validate(Input::all());
        if ($validator->passes()) {
            $data = Input::only('name', 'description');
            $data['address'] = $address;
            $charity = Charity::make($data);
            DB::beginTransaction();
            $charity->save();
            $permission = Permission::make(Auth::user(), $charity, null, 1);
            $permission->save();
            DB::commit();
            return Redirect::to('users/dashboard')
                ->with('message_success', "Charity {$charity->name} created successfully");
        } else {
            return Redirect::to('c/create')
                ->with('message_error', 'The Following errors occurred')
                ->withErrors($validator)
                ->withInput();
        }
    }

}
