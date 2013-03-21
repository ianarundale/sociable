<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_SociableTemplate {
//class Controller_Welcome extends Controller {

    public function before(){
        parent::before();
    }

	public function action_index()
	{
        $this->template->page_content = View::factory('partial/homepage');
	}

    public function after() {
        //$this->container->render();
        parent::after();
    }

} // End Welcome
