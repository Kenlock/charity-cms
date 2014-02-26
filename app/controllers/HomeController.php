<?php

class HomeController extends BaseController {
    
    public function getIndex() {
        return View::make('layout._single_column', array(
            'content' => View::make('home')
        ));
    }

}
