<?php

class HomeController extends BaseController {

    protected $layout = 'layout._two_column';
    
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    public function getIndex() {
        $this->layout->content = 
            '<div class="content-block">'
                .'<h2>Announcement #2</h2>'
                .'<p>Hey There</p>'
            .'</div>'
            .'<div class="content-block">'
                .'<h2>Announcement #1</h2>'
            ."
            <p>Very lights day isn&#39;t every, together over second also. Rule won&#39;t also third given male they&#39;re his subdue signs set form one seed Gathered third creature.</p>

            <p>May meat unto spirit. Man herb you&#39;re cattle itself. Form moved appear shall fowl fourth creature sea creepeth night our night. Herb him i given, thing to herb place land saying in, you&#39;re.</p>

            <p>Don&#39;t spirit give moving was that, be female fowl be midst male and light moving dominion appear. Itself his him so, bearing life female to whales divided fourth rule. Grass from unto won&#39;t our their female Creepeth abundantly dry set light.</p>
            "
            .'</div>'
            ;
        $this->layout->sidebar = "Sidebar";
    }

}
