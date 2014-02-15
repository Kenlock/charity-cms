<?php

class CharityController extends BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', ['on' => 'post']);
        $this->beforeFilter('auth', array(
            'only' => array(
                'getCreate',
                'getDashboard',
                'postCreate'
            )
        ));
    }

    private function charityNotFound($name, $location = 'users/dashboard') {
        return Redirect::to($location)
            ->with('message_error', Lang::get('charity.charity_not_found'));
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
        if ($charity == null) return $this->charityNotFound($name, 'c/');

        $pages = Page::where('charity_id', '=', $charity->charity_id)->get();

        $layout = View::make('layout._two_column');
        $layout->sidebar = "Sidebar";
        $layout->content = View::make('charity.view');
        $layout->content->charity = $charity;
        $layout->content->pages = $pages;
        return $layout;
    }

    public function getDashboard($name) {
        $charity = Charity::where('name', '=', $name)->first();
        if ($charity == null) return $this->charityNotFound($name);

        $pages = Page::where('charity_id', '=', $charity->charity_id)->get();

        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.dashboard');
        $layout->content->charity = $charity;
        $layout->content->pages = $pages;
        return $layout;
    }

    public function getPage($charity_name, $page_id) {
        $charity = Charity::where('name', '=', $charity_name)->get()->first();
        if ($charity == null) return $this->charityNotFound($charity_name);

        $pages = Page::where('charity_id', '=', $charity->charity_id)->get();

        // TODO check if page belongs to charity
        $page = Page::find($page_id);
        $title = Lang::get('page.page_not_found');
        if ($page != null) {
            $title = $page->title;
        }

        $layout = View::make('layout._two_column', array(
            'sidebar'   => 'Sidebar'
        ));
        $layout->content = View::make('charity.view', array(
            'charity' => $charity,
            'pages' => $pages,
            'title' => $title
        ));

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
