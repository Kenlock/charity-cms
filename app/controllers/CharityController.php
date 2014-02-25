<?php

use Cms\App\Sanitiser;

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

    public function getAbout($charity_name) {
        $charity = Charity::where('name', '=', $charity_name)->first();
        if ($charity == null) return $this->charityNotFound($charity_name);
        $pages = Page::where('charity_id', '=', $charity->charity_id)->get();

        return View::make('layout.charity._two_column', array(
            'charity' => $charity,
            'content' => View::make('charity.about', array(
                'charity' => $charity,
            )),
            'pages' => $pages,
            'sidebar' => View::make('charity.sidebar', array(
                'charity' => $charity
            ))
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

    public function getCharity($name, $page_id = 0) {

        $charity = Charity::with('pages')
            ->where('name', '=', $name)
            ->get()
            ->first();
        if ($charity == null) return $this->charityNotFound($name, 'c/');
        
        // get the default page_id
        $page_id = $page_id == 0 ? $charity->default_page_id : $page_id;

        $pages = $charity->pages;

        $page = $pages->filter(function($page) use($page_id) {
            return $page->page_id == $page_id;
        })->first();
        $page = $page == null ? $pages->first() : $page;

        $posts = Post::with('propertiesSmall')
            ->with('propertiesLarge')
            ->with('postView')
            ->orderBy('created_at', 'desc')
            #->limit(10)
            ->where('page_id', '=', $page->page_id)
            ->paginate(5);

        $layout = View::make('layout.charity._two_column', array(
            'charity' => $charity,
            'content' => View::make('charity.view', array(
                'charity' => $charity,
                'pages' => $pages,
                'title' => isset($page->title) ? $page->title : "Home",
                'content' => View::make('charity.posts', array(
                    'charity' => $charity,
                    'posts' => $posts
                ))
            )),
            'page' => $page,
            'pages' => $pages
        ));
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
        Input::merge(array(
            'address' => Charity::makeAddress(
                Input::get('address'),
                Input::get('address1'),
                Input::get('address2')
            )
        ));
        $sanitiser = Sanitiser::make(Input::all())
            ->guard('image')
            ->sanitise();


        $validator = Charity::validate($sanitiser->all());
        if ($validator->passes()) {
            $charity = Charity::makeAndSave(
                Input::get('name'),
                Input::get('charity_category_id'),
                Input::get('description'),
                Input::get('address'),
                Input::file('image')
            );
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
