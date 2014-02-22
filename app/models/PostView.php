<?php

class PostView extends Eloquent {
    const TABLE_NAME = 'post_views';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = self::TABLE_NAME;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    protected $guarded = array();
    protected $fillable = array();

    protected $primaryKey = 'post_view_id';

    private function getViewPath($viewName, $view) {
        return "postViews.{$viewName}.{$view}";
    }

    public function getDisplayView($post) {
        return View::make($this->getViewPath($this->view, 'display'), array('post' => $post));
    }

    public function getFormView() {
        return View::make($this->getViewPath($this->view, 'form'));
    }

    public static function getViewTitles() {
        $postViews = self::get();
        $titles = array();
        foreach ($postViews as $postView) {
            $titles[$postView->post_view_id] = $postView->title;
        }
        return $titles;
    }

    public function makePostValidator() {
        $p = "/views/postViews/{$this->view}/PostValidator.php";
        require app_path() . str_replace('/', DIRECTORY_SEPARATOR, $p);
        return new PostValidator();
    }

}
