<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Cms\App\Sanitiser;

/**
 * Class for acessing Charities
 * @author Aidan Grabe
 */
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

    /**
     * Display a charity's about page
     * @param string $charity_name the name of the charity
     */
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

    /**
     * Display the User creation form
     */
    public function getCreate() {
        $layout = View::make('layout._single_column');
        $layout->content = View::make('charity.create');
        return $layout;
    }

    /**
     * Get and display a charity's page
     * @param string $name the name of the charity
     * @param int $page_id optional. The id of the page to display. If none
     *      provided, will default to charity's default_page_id
     */
    public function getCharity($name, $page_id = 0) {

        $charity = Charity::with('pages')
            ->where('name', '=', $name)
            ->get()
            ->first();
        if ($charity == null) return $this->charityNotFound($name, 'c/');
        
        // get the default page_id
        $page_id = $page_id == 0 ? $charity->default_page_id : $page_id;

        $pages = $charity->pages;

        // get the current page
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
                'page' => $page,
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

    /**
     * Get a given charity's dashboard
     * @param string $name the name of the charity
     */
    public function getDashboard($name) {
        $charity = Charity::with('pages')
            ->where('name', '=', $name)
            ->first();
        if ($charity == null) throw new ModelNotFoundException;

        return View::make('layout._two_column', array(
            'content' => View::make('charity.dashboard', array(
                'charity' => $charity,
                'favorites' => Auth::user()->getFavoriteCharities(),
            ))
        ));
    }

    /**
     * Create a new Charity from a form
     */
    public function postCreate() {
        $data = Input::all();
        $data['address'] = Charity::makeAddress(
            Input::get('address'),
            Input::get('address1'),
            Input::get('address2'));

        // sanitise the data
        $sanitiser = Sanitiser::make($data)
            ->guard('image')
            ->sanitise();

        // create + validate the charity
        $charity = new Charity();
        $charity->validate($sanitiser->all());

        if ($charity->isValid()) {
            if (Input::hasFile('image')) $charity->image = Input::file('image');
            $charity->save();
            return Redirect::to('users/dashboard')
                ->with('message_success', "Charity {$charity->name} created successfully");
        }

        return Redirect::to('c/create')
            ->with('message_error', 'The Following errors occurred')
            ->withErrors($charity->getValidator())
            ->withInput();
    }

}
