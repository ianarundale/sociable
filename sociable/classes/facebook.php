<?php

/**
 * Provides access to the Facebook Platform.
 *
 * @package    Sociable/Facebook
 * @author     Ian Arundale <ian.arundale@gmail.com>
 * @copyright  (c) 2007-2012 Ian Arundale
 * @license    TBA
 */


class Facebook
{
    // Facebook instance
    protected static $_instance;

    /**
     * The Application ID.
     */
    protected $app_id;

    /**
     * The Application API Secret.
     */
    protected $app_secret;

    /**
     * The active user session, if one is available.
     */
    protected $my_url;

    /**
     * The access token to use when making API requests
     */
    protected $access_token;


    /**
     * Initialize a Facebook Application.
     *
     * The configuration:
     * - app_id: the application ID
     * - app_secret: the application secret
     * - my_url: URL to redirect to after authentication
     *
     * @param Array $config the application configuration
     */
    public function __construct($config)
    {
        $this->app_id = $config["app_id"];
        $this->app_secret = $config["app_secret"];
        $this->my_url = $config["my_url"];
        $this->access_token = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : false;
    }

    /**
     * Singleton pattern
     *
     * @return Auth
     */
    public static function instance()
    {
        if (!isset(Facebook::$_instance)) {
            // Load the facebook configuration
            $facebook_config = array(
                "app_id" => Kohana::$config->load('facebook_api_settings.' . "app_id"),
                "app_secret" => Kohana::$config->load('facebook_api_settings.' . "app_secret"),
                "my_url" => Kohana::$config->load('facebook_api_settings.' . "my_url"),
            );

            Facebook::$_instance = new Facebook($facebook_config);
        }

        return Facebook::$_instance;
    }

    /**
     * Maps aliases to Facebook domains.
     */
    public static $DOMAIN_MAP = array(
        'api' => 'https://api.facebook.com/',
        'api_read' => 'https://api-read.facebook.com/',
        'graph' => 'https://graph.facebook.com/',
        'www' => 'https://www.facebook.com/',
    );

    public function is_user_logged_in()
    {

        // if the access token is set, we're all good
        if (isset($this->access_token) && !empty($this->access_token)) {
            return true;
        } else {
            return false;
        }

        // otherwise we need to get hold of a token
        if (isset($_REQUEST["code"]) && !empty($_REQUEST["code"])) {
            $code = $_REQUEST["code"];
            return self::retrieve_access_token($code);
        } else {
            return false;
        }
    }

    /**
     * Redirect the user to the facebook login dialog
     * @return void
     */
    public function attempt_login()
    {
        // otherwise we need to get hold of a token
        if (isset($_REQUEST["code"]) && !empty($_REQUEST["code"])) {
            $code = $_REQUEST["code"];
            return self::retrieve_access_token($code);
        }


        $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
        $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
                      . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
                      . $_SESSION['state'] . "&scope=user_birthday,read_stream, user_location";

        // Send the user to facebook to authenticate, immediately exit to prevent any further PHP execution on our side
        header('Location: ' . $dialog_url, true);
        exit;
    }

    /**
     * Exchange the facebook login code for an access token
     *
     * @param String $code The code returned from facebook when authnticating a user
     * @return boolean True if the $code was successfully swapped for a valid authentication token, False otherwise.
     */
    private function retrieve_access_token($code)
    {
        if ($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                         . "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url)
                         . "&client_secret=" . $this->app_secret . "&code=" . $code;

            $response = file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);


            $_SESSION['access_token'] = $params['access_token'];
            return true;
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
            return false;
        }
    }

    private function api_call($url)
    {
        return json_decode(file_get_contents($url));
    }

    /**
     * Build the URL for given domain alias, path and parameters.
     *
     * @param $name String the name of the domain
     * @param $path String optional path (without a leading slash)
     * @param $params Array optional query parameters
     * @return String the URL for the given parameters
     */
    protected function get_url($name, $path = '', $params = array())
    {
        $url = self::$DOMAIN_MAP[$name];
        if ($path) {
            if ($path[0] === '/') {
                $path = substr($path, 1);
            }
            $url .= $path;
        }

        // Always append the access token
        if (!empty($this->access_token)) {
            $params = array_merge($params, array("access_token" => $this->access_token));
            if ($params) {
                $url .= '?' . http_build_query($params);
            }
        } else {
            throw new Exception("Invalid access token");
        }

        return $url;
    }


    // General functions for use by applications to query the users social graph

    public function get_user_info()
    {
        try {
            $url = $this->get_url("graph", "me");
            $user = $this->api_call($url);

        } catch (Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
        return $user;
    }

    public function get_user_news_feed()
    {
        try {
            $url = $this->get_url("graph", "me/home");
            $news_feed = $this->api_call($url);
            echo $url;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }

        return $news_feed->data;
    }

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

        return $data->metadata;
    }


}