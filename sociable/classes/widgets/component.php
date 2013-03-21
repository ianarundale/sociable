<?php

class Widgets_Component extends Widgets_Widget
{
    function __construct($id)
    {
        parent::__construct($id);
        echo "Component constructor<br />";
    }
}