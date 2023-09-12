<?php

namespace App\Http\Livewire\Components;

class Column
{

    public $title = '';

    public $field = '';

    public $headerClass = '';

    public $bodyClass = '';

    public $type = '';

    /**
     * Column constructor.
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $title
     * @return Column
     */
    public static function create(string $title = ''): Column
    {
        return new Column($title);
    }

    /**
     * Repository field for column
     * @return $this
     */
    public function field(string $field): Column
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Style classes for header column
     * @return $this
     */
    public function headerClass(string $headerClass): Column
    {
        $this->headerClass = $headerClass;

        return $this;
    }

    /**
     * Style classes for body column
     * @return $this
     */
    public function bodyClass(string $bodyClass): Column
    {
        $this->bodyClass = $bodyClass;

        return $this;
    }

    /**
     * Column type
     * Supported types: string, monetary, timestamps, year, image
     * @return $this
     */
    public function type(string $type): Column
    {
        $this->type = $type;

        return $this;
    }

}
