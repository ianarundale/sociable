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
            $this->template->header = View::factory('partials/header');
            $this->template->footer = View::factory('partials/footer');
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
            //$styles = array('assets/css/print.css' => 'print', 'assets/css/bootstrap.css' => 'screen');
            //$scripts = array();

            // Add defaults to template variables.
            $this->template->title .= " |  $this->site_name";
        }

        // Turn on full page caching when in production (is this a good thing for dynamic content?)
        if (Kohana::$environment === Kohana::PRODUCTION) {
            $this->response->headers('cache-control', 'max-age=3600, public');
        }

        // Run anything that needs to run after this.
        parent::after();
    }
}

?>