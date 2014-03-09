<?php

use Cms\App\Sanitiser;
use Cms\App\Validators\SocialLinkValidator;
use Cms\App\Exceptions\PermissionDeniedException;

/**
 * This controller handles access to the SocialLink model.
 * It is responsible for creating/editing social links for Charities
 * @author Aidan Grabe
 */
class SocialLinkController extends BaseController {

    /**
     * Display the create/edit social links form
     * @param int $charity_id the id of the charity that will own these links
     */
    public function getCreate($charity_id) {
        $charity = Charity::findOrFail($charity_id);

        $socialLinks = $charity->socialLinks;
        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException;

        // fill an array with default values to pass to the view
        $currentLinks = array();
        foreach (SocialLink::getValidServices() as $service) {
            $currentLinks[$service] = '';
        }

        // get the current links if they exist
        foreach ($socialLinks as $link) {
            $currentLinks[$link->service] = $link->url;
        }

        return View::make('layout._single_column', array(
            'content' => View::make('social.create', array(
                'charity'       => $charity,
                'currentLinks'  => $currentLinks
            ))
        ));
    }

    /**
     * Create/edit the social links
     * @param int $charity_id the id of the charity that will own these links
     */
    public function postCreate($charity_id) {
        $charity = Charity::findOrFail($charity_id);
        if (!Auth::user()->isAdmin($charity)) throw new PermissionDeniedException;

        // sanitise the input
        $data = Sanitiser::make(Input::all())
            #->guard(SocialLink::getValidServices())
            ->sanitise()
            ->all();
        
        // create our vlidation service
        $validator = new SocialLinkValidator($charity, $data);

        if ($validator->passes()) {
            $links = $validator->getSocialLinks();
            // save each link
            foreach ($links as $link) {
                $link->save();
            }
            return Redirect::action('CharityController@getDashboard', array($charity->name))
                ->with('message_success', 'Social Links updated successfully');
        }
        return Redirect::back()
            ->withInput()
            ->withErrors($validator->errors());
    }

}
