<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Auth_Template extends Controller_SociableTemplate
{
    public function before()
    {
        // Check that the user is logged in before proceeding
        if (!SociableFacebookAdapter::get_instance()->is_user_logged_in()) {
            $this->redirect('account');
        }

        parent::before();
    }
}