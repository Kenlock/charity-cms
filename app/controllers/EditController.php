<?php

use Cms\App\Exceptions\PermissionDeniedException;

class EditController extends BaseController {

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
