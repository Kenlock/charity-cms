<?php namespace observers;

use Exception;
use Log;
use Mail;

/**
 * Observer to hook into Comment model events
 * @author Aidan Grabe
 */
class CommentObserver {

    /**
     * Send the charity an email when somone has commented on their post
     * @param Comment $comment the comment that has been created
     */
    public function created($comment) {
        $post = $comment->post;
        $page = $post->page;
        $charity = $page->charity;

        $data = array(
            'charity'   => $charity,
            'page'      => $page,
            'post'      => $post
        );

        // send the email
        try {
            Mail::queue('emails.comment', $data, function($message) use($charity) {
                $message->to($charity->email, $charity->name)
                    ->subject("New Comment for {$charity->name}");
            });
        } catch (Exception $e) {
            Log::error("Failed to send new comment email. " . $e);
        }
    }

}
