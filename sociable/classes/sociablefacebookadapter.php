<?php

/**
 * Copyright 2011 Ian Arundale.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * Provides access to the Facebook Platform.
 *
 * @author     Ian Arundale <ian.arundale@gmail.com>
 * @copyright  (c) 2012 Ian Arundale
 */

class SociableFacebookAdapter extends Facebook
{

    private static $_instance = null;

    /**
     * Singleton pattern
     *
     * @return Auth
     */
    public static function get_instance()
    {
        if (!isset(SociableFacebookAdapter::$_instance)) {
            // Load the facebook configuration
            $facebook_config = array(
                "appId" => Kohana::$config->load('facebook_api_settings.' . "app_id"),
                "secret" => Kohana::$config->load('facebook_api_settings.' . "app_secret")
            );

            SociableFacebookAdapter::$_instance = new SociableFacebookAdapter($facebook_config);
        }

        return SociableFacebookAdapter::$_instance;
    }

    /**
     * Initialize a Facebook Application.
     *
     * The configuration:
     * - app_id: the application ID
     * - app_secret: the application secret
     *
     * @param Array $config the application configuration
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }


    /**
     * Returns true or false depending on in the current user is logged into facebook
     * @return bool True if a user is logged in, false otherwise
     */
    public function is_user_logged_in()
    {
        $result = (boolean)self::getUser();
        return $result;
    }

    /**
     * Returns true or false depending on in the current user is logged into facebook
     * @return bool True if a user is logged in, false otherwise
     */
    public function get_user_id()
    {
        return self::getUser();
    }

    /**
     * Redirect the user to the facebook login dialog to authenticate, immediately exit
     * to prevent any further PHP execution on our side
     * @return void
     */
    public function log_user_into_facebook()
    {
        // TODO: Parameterise redirect_url and scope values
        $login_config = array(
            "redirect_uri" => "http://sociable.local/account/facebooklogin",
            "scope" => "user_birthday, read_stream, user_location, publish_stream, email, read_friendlists, publish_checkins, user_education_history, user_work_history"
        );
        $login_url = self::getLoginUrl($login_config);
        header('Location: ' . $login_url, true);
        exit;
    }

    /**
     * Log a user out of facebook
     * @return void
     */
    public function log_user_out_of_facebook()
    {
        // TODO: Parameterise redirect_url and scope values
        $logout_config = array(
            "next" => "http://sociable.local/"
        );
        $logout_url = self::getLogOutUrl($logout_config);

        // Unset the session
        $_SESSION = array();
        session_destroy();

        // Log the user out
        header('Location: ' . $logout_url, true);
        exit;
    }

    /**
     * Returns the basic user information about the person who is logged in
     * @return mixed Object
     */
    public function get_user_info()
    {
        try {
            $user_info = self::api("me");
        } catch (Exception $e) {
            // TODO: Handle the error
            // Set the return value to be an empty array
            $user_info = array();
        }

        return $this->convert_array_to_object($user_info);
    }

    public function get_all_friends()
    {
        try {
            $friends = self::api("me/friends");
        } catch (Exception $e) {
            // TODO: Handle the error
            // Set the return value to be an empty array
            $user_info = array();
        }

        return $this->convert_array_to_object($friends['data']);
    }

    /**
     * Returns the last 25 items in the users home news feed
     * @return mixed Object
     */
    public function get_users_news_feed()
    {
        try {
            $news_stream = self::api("me/home");
        } catch (Exception $e) {
            // TODO: Handle the error
            // Set the return value to be an empty array
            $news_stream = array();
        }

        return $this->convert_array_to_object($news_stream['data']);
    }

    /**
     * Returns a list of permissions
     * @return mixed Object
     */
    public function get_available_permissions()
    {
        try {
            $url = $this->get_url("graph", "me", array("metadata" => "1"));
            $data = $this->api_call($url);
            //echo $url;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }

        return $this->convert_array_to_object($data->metadata);
    }

    /**
     * Post an item to the currently logged in users facebook steam
     * @param $activity
     * @return void
     */
    public function publish_to_stream($activity)
    {

    }

    /**
     * Takes an array and converts it into a stdClass object
     * @param $array
     * @return mixed Array
     */
    private function convert_array_to_object($array)
    {
        return json_decode(json_encode($array), FALSE);
    }


}