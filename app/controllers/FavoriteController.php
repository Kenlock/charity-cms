<?php

class FavoriteController extends BaseController {

    /**
     * Add a charity to the currently logged in user's favorites
     * @param string $charity_name the name of the charity to favorite
     * @return Redirect
     */
    public function favoriteCharity($charity_name) {
        $charity = Charity::where('name', '=', $charity_name)->first();
        if ($charity == null) return Redirect::back()->with('message_error', Lang::get('charity.charity_not_found'));
        if (!Auth::check()) return Redirect::to('users/login')->with('message_error', Lang::get('favorite.must_be_logged_in'));

        $alreadyFavorite = Favorite::where('user_id', '=', Auth::user()->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->count();
        if ($alreadyFavorite > 0) return Redirect::back()->with('message_error', Lang::get('favorite.already_favorite'));


        $fav = new Favorite();
        $fav->user_id = Auth::user()->user_id;
        $fav->charity_id = $charity->charity_id;
        $fav->save();

        return Redirect::back()
            ->with('message_success', Lang::get('favorite.success'));
    }

}
