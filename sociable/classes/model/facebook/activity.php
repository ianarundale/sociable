<?php
defined('SYSPATH') or die('No direct script access.');

/*
 * @author Ian Arundale
 */

class Model_Facebook_Activity extends Model_Activity
{
    public function __construct($activity_object)
    {
        self::__construct($activity_object);
    }

    public static function create_activity_collection($facebook_activity_collection)
    {
        $activity_collection = array();

        foreach ($facebook_activity_collection as $activity) {
            if(!isset($activity->message)){
                continue;
            }
            $activity_object = new Model_Activity($activity);
            array_push($activity_collection, $activity_object);
        }

        return $activity_collection;
    }
}

?>
