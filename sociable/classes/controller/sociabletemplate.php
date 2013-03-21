<?php
 defined('SYSPATH') or die('No direct script access.');

class Controller_SociableTemplate extends Controller_Template
{
    public $template = 'templates/base';
    public $site_name = 'Sociable';

    /**
     * Initialize properties before running the controller methods (actions),
     * so they are available to our action.
     */
    public function before()
    {

        // Run anything that need ot run before this.
        parent::before();

        if ($this->auto_render) {
            // Initialize empty values
            $this->template->title = 'Something';
            $this->template->meta_keywords = '';
            $this->template->meta_description = '';
            $this->template->meta_copywrite = 'Sociable';
            $this->template->header = View::factory('partial/header');
            $this->template->footer = View::factory('partial/footer');;
            $this->template->styles = array();
            $this->template->scripts = array();
        }
    }

    /**
     * Fill in default values for our properties before rendering the output.
     */
    public function after()
    {
        if ($this->auto_render) {
            // Define defaults
            $styles = array('assets/css/print.css' => 'print', 'assets/css/bootstrap.css' => 'screen'); //assets/js/fancybox/jquery.fancybox-1.3.1.css
            $scripts = array(); // array('assets/js/fastbleepnotes.js','assets/js/fast.js','assets/js/fancybox/jquery.fancybox-1.3.1.js', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.js','http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');

            // Add defaults to template variables.
            $this->template->title .= " |  $this->site_name";
        }

        // Run anything that needs to run after this.
        parent::after();
    }

    /**
     * Convinience method to check if a user is logged into the system or not
     */
    public static function userLoggedIn()
    {
        if (Auth::instance()->logged_in()) {
            return true;
        } else {
            return false;
        }
    }
}

?>