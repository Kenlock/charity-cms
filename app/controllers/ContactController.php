<?php

/**
 * Controller for sending messages to the admins of the site by email
 * @author Aidan Grabe
 */
class ContactController extends BaseController {

    /**
     * Display the contact form
     */
    public function getContact() {
        return View::make('layout._single_column', array(
            'content'   => View::make('contact')
        ));
    }

    /**
     * Validate the form sent, send the email and redirect
     */
    public function postContact() {
        $validator = Validator::make(Input::all(), array(
            'email' => 'required|email',
            'content' => 'required'
        ));

        if ($validator->passes()) {
            try {
                Mail::queue('emails.contact', array(
                        'email' => Input::get('email'),
                        'name'  => Input::get('name'),
                        'content' => Input::get('content')
                        ), function($message) {
                    $to = Config::get('mail.from');
                    $message->subject('Altruisco Contact')
                        ->from(Input::get('email'), Input::get('name'))
                        ->to($to['address'], $to['name']);
                });
            } catch (Exception $e) {
                Log::error('Failed to send mail: \n' . $e);
            }
            return Redirect::back()
                ->with('message_success', 'Your message has been sent');
        }
        return Redirect::back()
            ->withInput()
            ->withErrors($validator)
            ->with('message_success', Lang::get('forms.errors_occurred'));
    }

}
