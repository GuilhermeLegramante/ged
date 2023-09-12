<?php

namespace App\Http\Livewire\Components;

class Button
{
    public $view = 'partials.buttons.icon';

    public $title = '';

    public $method = '';

    public $class = '';

    public $icon = '';

    public $target = '';

    /**
     * Button constructor.
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $title
     * @return Button
     */
    public static function create(string $title = ''): Button
    {
        return new Button($title);
    }

    /**
     * Method for button
     * @return $this
     */
    public function method(string $method): Button
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Class string in view: class="foo"
     * @return $this
     */
    public function class(string $class): Button
    {
        $this->class = $class;

        return $this;
    }

    /**
     * target _blank, _self, _top, _parent, null
     * @param string $target
     * @return $this
     */
    public function target(string $target): Button
    {
        $this->target = $target;

        return $this;
    }

    /**
     * View file
     * @param string $view
     * @return $this
     */
    public function view(string $view): Button
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Fontawesome Icon class
     * @param string $icon
     * @return $this
     */
    public function icon(string $icon): Button
    {
        $this->icon = $icon;

        return $this;
    }

}
