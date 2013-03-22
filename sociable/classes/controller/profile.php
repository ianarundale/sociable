<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Profile extends Controller_SociableTemplate
{

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        session_start();
        $page = $this->template->page_content = View::factory('profile/index');
        $facebook = Facebook::instance();
        if($facebook->is_user_logged_in()){
            $news_feed = $facebook->get_user_news_feed();
        } else {
            $news_feed = array();
        }

        $formatted_news_feed = View::factory("formatters/newsfeed", array("normalized_news_feed" => $news_feed));

        $user = $facebook->get_user_info();
        $page->user = $user;

        $page->news_feed = $formatted_news_feed;
    }

    public function after()
    {
        parent::after();
    }

}