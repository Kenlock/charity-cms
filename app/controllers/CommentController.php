<?php

use \Cms\App\Sanitiser;

class CommentController extends BaseController {
    
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array(
            'only' => array(
                'getDashboard'
            )
        ));
    }

    public function postCreate($post_id) {

        $post = Post::find($post_id);
        if ($post == null) Redirect::back()->with('message_error', "Post not found");

        $comment = Comment::make(Auth::user(), $post, Input::get('comment'));
        $validator = $comment->validate();

        if ($validator->passes()) {
            $comment->save();
            return Redirect::back()
                ->with('message_success', Lang::get('comments.success'));
        } else {
            return Redirect::back()
                ->with('message_error', Lang::get('comments.error'))
                ->withErrors($validator)
                ->withInput();
        }
    }

}
