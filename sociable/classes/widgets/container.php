<?php

/**
 * Container contains widgets
 */

abstract class Widgets_Container extends Widgets_Widget
{
    /**
     * Renders the child widgets that have been appended to the container
     */

    function __construct($id)
    {
        parent::__construct($id);
        $this->childWidgets = array();
    }

    public function appendChildWidget($widget)
    {

        //if (!$this->hasChildWidget($widget->getId())) {
            array_push($this->childWidgets, $widget);
        //}



    }

    /**
     * Renders a containers child widgets to the buffered output
     * @return void
     */
    public function render()
    {
        for ($i = 0; $i < count($this->childWidgets); $i++) {
            $this->childWidgets[$i]->render();
        }

        /**
         *
         * if(!this.outputElement) {
        this.outputElement = device.createContainer(this.id, this.getClasses());
        } else {
        device.clearElement(this.outputElement);
        }
        for(var i=0; i<this._childWidgetOrder.length; i++) {
        device.appendChildElement(this.outputElement, this._childWidgetOrder[i].render(device));
        }
        return this.outputElement;
        },
         *
         */
    }

}