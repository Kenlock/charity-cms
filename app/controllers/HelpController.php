<?php

class HelpController extends BaseController {

    public function getFaq() {
        $faq = new Cms\App\Faq();
        $faq->langQuestion('delete_charity')
            ->langQuestion('charity_limit')
            ->langQuestion('charity_register')
            ->langQuestion('charity_new_page')
            ->langQuestion('post_layout_types')
            ->langQuestion('favorite_charity')
            ->langQuestion('unfavorite_charity')
            ->langQuestion('who_can_comment')
            ;

        return View::make('layout._two_column', array(
            'content' => View::make('help.faq', array(
                'faq' => $faq
            )),
        ));
    }

}
