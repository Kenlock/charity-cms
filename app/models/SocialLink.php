<?php

/**
 * SocialLink Model
 * A social link is no more than the name of a social website, and a link to
 * the Charity's page on that website.
 * The static $services variable defines which social network links to allow.
 * @author Aidan Grabe
 */
class SocialLink extends BaseModel {
    const TABLE_NAME    = 'social_links';

    protected $fillable = array(
        'charity_id', 'service', 'url'
    );

    /**
     * @var array
     *      the valid names of services which will be displayed in the forms
     *      for creating new links
     */
    private static $services = array(
        'twitter', 'facebook', 'google', 'youtube'
    );

    /**
     * Create the validation rules in the constructor since we're using
     * a static variable in on of the rules declarations (blame PHP!)
     */
    public function __construct() {
        parent::__construct();

        $services = implode(',' , static::getValidServices());
        $this->rules = array(
            'service'   => "required|in:{$services}",
            'url'       => "url"
        );
    }
    
    public function charity() {
        return $this->belongsTo('Charity', 'charity_id', 'charity_id');
    }

    /**
     * get the valid service names of social websites
     * @return array an array of strings containing the names of the valid
     *      services
     */
    public static function getValidServices() {
        return static::$services;
    }

    /**
     * Create a new instance of this class
     * @param Charity $charity the charity that owns this instance
     * @param string $service the name of the social website
     * @param string $url the url to the charity's page on the social website
     * @return SocialLink a new SocialLink instance
     */
    public static function make(Charity $charity, $service, $url) {
        $socialLink = new SocialLink();
        $socialLink->validate(array(
            'charity_id'=> $charity->charity_id,
            'service'   => $service,
            'url'       => $url
        ));
        return $socialLink;
    }

}
