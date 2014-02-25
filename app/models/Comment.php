<?php

class Comment extends Eloquent {
    const TABLE_NAME = 'comments';

    const VIEW = 'comments.single';

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

    public function __toString() {
        return View::make(self::VIEW, array(
            'comment' => $this
        ))->__toString();
    }

    public function getCommentAttribute() {
        return Markdown::string($this->attributes['comment']);
    }

    /**
     * Get the time this comment was created at
     * @param bool $timeFormat optional. If true, get the creation time as a
     *      timestamp. If false get the date as stored in the database
     * @return mixed the creation time either as a timestamp or the format
     *      stored in the database
     */
    public function getCreatedAt($timeFormat = true) {
        return $timeFormat
            ? strtotime($this->attributes['created_at'])
            : $this->attributes['created_at'];
    }

    public static function make(User $user, Post $post, $content) {
        $comment = new Comment();
        $comment->fill(array(
            'user_id' => $user->user_id,
            'post_id' => $post->post_id,
            'comment' => $content,
        ));
        return $comment;
    }

    public function post() {
        return $this->hasOne('Post', 'post_id', 'post_id');
    }

    public function user() {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

    public function validate() {
        return Validator::make($this->attributes, array(
            'user_id' => 'required|integer|exists:users',
            'post_id' => 'required|integer|exists:posts',
            'comment' => 'required'
        ));
    }

}
