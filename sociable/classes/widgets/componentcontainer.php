<?php

class Widgets_ComponentContainer extends Widgets_Container
{
    function __construct($id)
    {
        parent::__construct($id);
        echo "component container";
    }
}