<?php

class PostController extends BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
    }

    private function pageNotFound() {
        return Redirect::to('/')
            ->with('message_error', Lang::get('page.page_not_found'));
    }

    private function permissionDenied() {
        return Redirect::to('/')
            ->with('message_error', Lang::get('strings.permission_denied'));
    }

    private function viewNotFound() {
        return Redirect::to('/')
            ->with('message_error', Lang::get('strings.view_not_found'));
    }

    public function getCreate($page_id, $view_id = 0) {
        $page = Page::find($page_id);

        if ($page == null) return $this->pageNotFound();
        if (!Auth::user()->canPostTo($page)) return $this->permissionDenied();

        $view_id = $view_id == 0 ? $page->default_view_id : $view_id;
        $view = PostView::find($view_id);

        if ($view == null) return $this->viewNotFound();

        $formView = View::make("postViews.form", array(
            'page' => $page,
            'view' => $view
        ));

        $layout = View::make('layout._single_column');    
        $layout->content = $formView;
        return $layout;
    }

    public function postCreate($page_id) {
        $page = Page::find($page_id);

        if ($page == null) return $this->pageNotFound();
        if (!Auth::user()->canPostTo($page)) return $this->permissionDenied();

        $view_id = Input::get('view_id');
        $view = PostView::find($view_id);

        if ($view == null) return $this->viewNotFound();

        $postValidator = $view->makePostValidator();
        $validator = $postValidator->validate();
        if ($validator->passes()) {
            $data = $postValidator->onSuccess();

            Post::makeAndSave(Auth::user(), $page, $view, Input::get('title'), $data);

            return Redirect::to("posts/create/{$page_id}")
                ->with('message_success', Lang::get('postViews.success'));
        } else {
            return Redirect::to("posts/create/{$page_id}")
                ->with('message_error', Lang::get('postViews.error'))
                ->withErrors($validator)
                ->withInput();
        }
    }

}
