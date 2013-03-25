<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile extends Controller_Auth_Template
{

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $page = $this->template->page_content = View::factory('profile/index');
        $facebook = SociableFacebookAdapter::get_instance();

        //print_r($facebook->get_user_info()); exit;

        $page->user = $facebook->get_user_info();
    }

    public function action_activity()
    {
        $page = $this->template->page_content = View::factory('profile/activity');
        $facebook = SociableFacebookAdapter::get_instance();

        $news_feed = $facebook->get_users_news_feed();

        $formatted_news_feed = View::factory("formatters/newsfeed", array("normalized_news_feed" => $news_feed));

        $user = $facebook->get_user_info();
        $page->user = $user;

        $page->news_feed = $formatted_news_feed;
    }

    public function action_friends()
    {
        $page = $this->template->page_content = View::factory('profile/friends');
        $facebook = SociableFacebookAdapter::get_instance();

        //print_r($facebook->get_all_friends());
        $page->friends = $facebook->get_all_friends();
    }

    public function action_facebook()
    {
        $facebook = SociableFacebookAdapter::get_instance();
        // Get User ID
        $user = $facebook->getUser();

        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.

        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }

        // Login or logout url will be needed depending on current user state.
        if ($user) {
            $this->redirect('profile');
            $logoutUrl = $facebook->getLogoutUrl();
        } else {
            $loginUrl = $facebook->getLoginUrl();
        }

        header('Location: ' . $loginUrl, true);


        // This call will always work since we are fetching public data.
        $naitik = $facebook->api('/ianarundale');

        print_r($naitik);
        exit;


    }

    public function after()
    {
        parent::after();
    }

}