<?php defined('SYSPATH') or die('No direct script access.');

class Components_Header extends Widgets_Component {
    function __construct($id){
        parent::__construct($id);
        echo "hello world";
    }

    function render(){
        echo "Render called";
    }
}
