<?php

use Cms\App\Exceptions\PermissionDeniedException;
use Cms\App\Sanitiser;

/**
 * Controller to handle editting things
 * @author Aidan Grabe
 */
class EditController extends BaseController {

    public function __construct() {
        $this->beforeFilter('upload.max', array('on' => 'post'));
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Display the form to update the charity
     * @param int $charity_id the charity's id
     */
    public function getCharity($charity_id) {
        $charity = Charity::findOrFail($charity_id);
        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException; 

        if (!Input::has('address')) {
            $address = explode(',', $charity->address);
            Input::merge(array(
                'address' => $address[0],
                'address1' => $address[1],
                'address2' => $address[2],
            ));
        }

        return View::make('layout._single_column', array(
            'content' => View::make("charity.edit", array(
                'charity'   => $charity
            ))
        ));
    }

    /**
     * Update the Charity
     * @param $charity_id int the id of the charity to be updated
     * @return Redirect
     */
    public function postCharity($charity_id) {
        $charity = Charity::findOrFail($charity_id);
        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException; 
        
        $data = Input::all();
        $data['address'] = Charity::makeAddress(
            Input::get('address'),
            Input::get('address1'),
            Input::get('address2')
        );
        $sanitiser = Sanitiser::make($data)
            ->guard('image')
            ->sanitise();
        $charity->validateUpdate($sanitiser->all());

        if ($charity->isValid()) {
            if (Input::hasFile('image')) $charity->image = Input::file('image');
            $charity->save();
            return Redirect::back()
                ->with('message_success', Lang::get('charity.edit_success'));
        }

        return Redirect::back()
            ->with('message_error', Lang::get('forms.errors_occurred'))
            ->withErrors($charity->getValidator())
            ->withInput();
    }

    public function getPage($page_id) {
        $page = Page::findOrFail($page_id);
        if (!Auth::user()->canDelete($page))
            throw new PermissionDeniedException;

        return View::make('layout._single_column', array(
            'content' => View::make("pages.edit", array(
                'model' => $page

            ))
        ));
    }

    public function postPage($page_id) {
        $page = Page::findOrFail($page_id);
        if (!Auth::user()->canDelete($page))
            throw new PermissionDeniedException;

        $page->validateUpdate(Input::all());

        $page->open_to_all = Input::has('open_to_all');

        if ($page->isValid()) {
            $page->save();
            return Redirect::back()
                ->with('message_success', Lang::get('forms.page_edited'));
        }
        return Redirect::back()
            ->withInput()
            ->withErrors($page->getValidator())
            ->with('message_error', Lang::get('forms.errors_occurred'));
    }

    public function getStyle($charity_id) {
        $charity = Charity::findOrFail($charity_id);

        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException;

        return View::make('layout.charity._two_column', array(
            'charity' => $charity,
            'content' => View::make('charity.edit_styles', array(
                'charity'   => $charity
            )),
            'pages' => $charity->pages
        ));
    }

    public function postStyle($charity_id) {
        $charity = Charity::findOrFail($charity_id);

        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException;
        
        $style = new CharityStyle();
        $style->fill(array(
            'charity_id'    => $charity_id,
            'property'      => 'background-color',
            'value'         => '#' . e(Input::get('background-color'))
        ));
        $style->save();

        return Redirect::back()
            ->with('message_success', 'Colors Successfully editted')
            ->withInput();
    }

}
