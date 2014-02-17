<?php

class Post extends Eloquent {
    const TABLE_NAME = 'posts';

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
    
    protected $primaryKey = 'post_id';

    public function getLargeProperty($key) {
        foreach ($this->propertiesLarge as $prop) {
            if ($prop->title == $key) return $prop->content;
        }
        return '';
    }

    public function getProperty($key) {
        $property = $this->getSmallProperty($key);
        return $property == '' ? $this->getLargeProperty($key) : $property;
    }

    public function getSmallProperty($key) {
        foreach ($this->propertiesSmall as $prop) {
            if ($prop->title == $key) return $prop->content;
        }
        return '';
    }

    public static function makeAndSave(User $user, Page $page, PostView $view, $title, $data) {
        DB::beginTransaction();
        $post = new Post();
        $post->fill(array(
            'user_id' => $user->user_id,
            'page_id' => $page->page_id,
            'view_id' => $view->post_view_id,
            'title' => e($title)
        ));
        $post->save();
        foreach ($data as $size => $rows) {
            foreach ($rows as $key => $row) {
                $data[$size][$key]['post_id'] = $post->post_id;
            }
        }
        PostPropertySmall::insert($data['small']);
        PostPropertyLarge::insert($data['large']);
        DB::commit();
    }

    public function postView() {
        return $this->hasOne('PostView', 'post_view_id', 'view_id');
    }

    public function page() {
        return $this->hasOne('Page', 'page_id', 'page_id');
    }

    public function propertiesSmall() {
        return $this->hasMany('PostPropertySmall');
    }

    public function propertiesLarge() {
        return $this->hasMany('PostPropertyLarge');
    }

}
