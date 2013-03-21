<?php

class Widgets_Widget
{
    function __construct($id)
    {
        $this->id = $id;
        $this->classNames = array();
    }

    public function render()
    {
        throw Exception ("Widget::render called - the subclass for widget '" +
                        $this->id + "' must have not overridden the render method.");
    }

    public function addClass($className)
    {
        array_push($this->classNames, $className);
    }

    public function hasClass($className)
    {
        return "not implemented";
    }
}