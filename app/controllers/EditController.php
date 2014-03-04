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



}
