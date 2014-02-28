<?php

class FavoriteController extends BaseController {

    public function __construct() {
        
        $this->beforeFilter('auth');
    }

    /**
     * Add a charity to the currently logged in user's favorites
     * @param string $charity_name the name of the charity to favorite
     * @return Redirect
     */
    public function favoriteCharity($charity_name) {
        $charity = Charity::where('name', '=', $charity_name)->first();
        if ($charity == null) return Redirect::back()->with('message_error', Lang::get('charity.charity_not_found'));

        $alreadyFavorite = Favorite::where('user_id', '=', Auth::user()->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->count();
        if ($alreadyFavorite > 0) {
            return Redirect::back()->with('message_error',
                Lang::get('favorite.already_favorite',
                    array(
                        'link' => HTML::link("unfavorite/{$charity_name}", Lang::get('strings.here'))
                    )
                )
            );
        }


        $fav = new Favorite();
        $fav->user_id = Auth::user()->user_id;
        $fav->charity_id = $charity->charity_id;
        $fav->save();

        return Redirect::back()
            ->with('message_success', Lang::get('favorite.success'));
    }

    /**
     * Un-favorite a charity
     * @param string $charity_name the name of the chairty to un-favorite
     */
    public function unfavoriteCharity($charity_name) {
        $charity = Charity::where('name', '=', $charity_name)->first();
        if ($charity == null) return Redirect::back()->with('message_error', Lang::get('charity.charity_not_found'));

        $user = Auth::user();

        $favs = Favorite::where('user_id', '=', $user->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->delete();

        return Redirect::back()->with('message_success', Lang::get('favorite.success_unfavorite'));
    }

}
