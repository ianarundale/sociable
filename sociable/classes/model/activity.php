<?php
defined('SYSPATH') or die('No direct script access.');

/*
 * @author Ian Arundale
 */

class Model_Activity
{
    /**
     * @param $id
     * @param $from
     * @param $message
     * @param $privacy
     * @param $type
     * @param $created_time
     * @param $updated_time
     */
    public function __construct($activity_object){
        $this->id = $activity_object->id;
        $this->from = $activity_object->from;
        $this->message =  $activity_object->message;
        $this->privacy = $activity_object->privacy;
        $this->type = $activity_object->type;
        $this->created_time = $activity_object->created_time;
        $this->updated_time = $activity_object->updated_time;
    }
}

?>
