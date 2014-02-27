<?php namespace Cms\App;

use \HTML;
use \Lang;

class Faq {

    private $questions;

    public function __construct() {
        $this->questions = array();
    }

    public function addQuestion($question, $answer) {
        $this->questions[] = array(
            'anchor' => 'faq_' . e(str_replace(' ', '_', $question)),
            'q' => $question,
            'a' => $answer
        );
        return $this;
    }

    public function getContent() {
        $output = '';
        foreach ($this->questions as $question) {
            $output .= "<h2 id=\"{$question['anchor']}\">{$question['q']}</h2>";
            $output .= "<p>{$question['a']}</p>";
        }
        return $output;
    }

    public function getMenu() {
        $output = '';
        foreach ($this->questions as $question) {
            $output .= '<li>';
            $output .= HTML::link("#{$question['anchor']}", $question['q']);
            $output .= '</li>';
        }
        return "<ul>{$output}</ul>";
    }

    public function langQuestion($key, $file = 'faq') {
        return $this->addQuestion(Lang::get("{$file}.q.{$key}"), Lang::get("{$file}.a.{$key}"));
    }

}
