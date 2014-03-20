<?php

use \Markdown;
use observers\PostObserver;

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

    public function author() {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

    /**
     * Register the Post observer on boot
     */
    public static function boot() {
        parent::boot();
        
        static::observe(new PostObserver());
    }

    public function comments() {
        return $this->hasMany('Comment', 'post_id', 'post_id')->orderBy('created_at', 'desc');
    }

    public function delete() {
        $this->comments()->delete();

        return parent::delete();
    }

    public function getCreatedAtAttribute() {
        return strtotime($this->attributes['created_at']);
    }

    public function getLargeProperty($key) {
        foreach ($this->propertiesLarge as $prop) {
            if ($prop->title == $key) return $prop->content;
        }
        return '';
    }

    /**
     * Get the post's link
     */
    public function getLink() {
        return "posts/single/{$this->page->charity->name}/{$this->post_id}";
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

    /**
     * load this instance's properties from the PostPropertyLarge and
     * PostPropertySmall tables, and make them accessible via $this->{$name}
     */
    public function loadProperties() {
        $sizes = array();
        $sizes[] = $this->propertiesLarge->all();
        $sizes[] = $this->propertiesSmall->all();
        foreach ($sizes as $properties) {
            foreach ($properties as $property) {
                $this->{$property->title} = $property->content;
            }
        }
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

    /**
     * Get a particular attribute converted to Markdown
     * @param string the name of the attribute to retrive as Markdown
     * @return string Markdown equivalent of $this>$name
     */
    public function markdown($name) {
        return Markdown::string($this->{$name});
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

    /**
     * Check if a given user has permission to delete the current post
     * @param User $user the user to check against
     * @return boolean true if the user has permission to delete this post,
     *      false if she does not
     */
    public function userCanDelete($user) {
        // if the user is a guest
        if (!isset($user)) return false;

        // if the user is the author of the post
        if ($this->author->user_id == $user->user_id) return true;

        // if the user can delete posts for this post's page
        $permissions = Permission::where('user_id', '=', $user->user_id)
            ->where('charity_id', '=', $this->page->charity->charity_id)
            ->where(function($query) {
                $query->where('page_id', '=', $this->page->page_id)
                    ->orWhere('page_id', '=', 0);
            })
            ->count();
    
        return $permissions > 0;

    }

}
