<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_SociableTemplate
{
//class Controller_Welcome extends Controller {

    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->page_content = View::factory('home/index');
    }

    public function action_facebook()
    {
        session_start();
        $this->auto_render = false;

        $facebook = Facebook::instance();

        $basic_info = $facebook->get_user_info();
        $news_feed = $facebook->get_user_news_feed();

        print_r($basic_info);
        //print_r($news_feed);
    }

    public function after()
    {
        //$this->container->render();
        parent::after();
    }

} // End Welcome
