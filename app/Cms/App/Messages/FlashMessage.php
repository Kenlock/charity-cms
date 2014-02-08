<?php namespace Cms\App\Messages;

/**
 * @author Aidan Grabe
 * A simple message that can have content and HTML class
 */
class FlashMessage {
    private $classes;
    private $message;

    public function __construct($message, $classes = []) {
        $this->classes = is_string($classes) ? [$classes] : $classes;
        $this->classes[] = "msg";
        $this->message = $message;
    }

    public function __toString() {
        return '<div class="' . $this->getClassesAsString() . '">'
                . $this->message
                . '</div>';
    }

    public function getClasses() {
        $classes = [];
        foreach ($this->classes as $c) {
            $classes = array_merge($classes, explode(' ', $c));
        }
        return $classes;
    }

    public function getClassesAsString() {
        return implode(" ", $this->classes);
    }

    public function setClasses($classes) {
        $this->classes = is_string($classes)
            ? array_merge($this->classes, [$classes])
            : array_merge($this->classes, $classes);
    }

    public function setMessage($message) {
        $this->message = $message;
    }

}
