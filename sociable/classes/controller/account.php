<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller
{

    public function action_index()
    {
        $this->redirect('account/facebooklogin');
    }

    public function action_facebooklogin()
    {
        session_start();
        $facebook = Facebook::instance();

        if (!$facebook->is_user_logged_in()) {
            $facebook->attempt_login();
        }

        $this->redirect('/profile');
    }

    public function action_logout()
    {
        session_start();
        session_destroy();
        $this->redirect('welcome');
    }
}