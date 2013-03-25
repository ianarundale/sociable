<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Controller_Account handles the sticky bits of logging in/out and redirected appropriately (never returns response)
 */
class Controller_Account extends Controller
{

    public function action_index()
    {
        $this->redirect('account/facebooklogin');
    }

    public function action_facebooklogin()
    {
        $facebook = SociableFacebookAdapter::get_instance();

        if (!$facebook->is_user_logged_in()) {
            $facebook->log_user_into_facebook();
        } else {
            $result = null;
            // The user is logged into facebook, lets check if they are already in our database
            try {
                $result = ORM::factory("user")->where("facebook_id", "=", $facebook->get_user_id())->find();
            } catch (Exception $e) {
                echo "exception";
            }

            // if the user could not be found in the database, add them
            if (!$result->loaded()) {

                // get the facebook information
                $facebook_user = $facebook->get_user_info();

                // add the user
                $user = new Model_User();
                $user->username = $facebook_user->username;
                $user->firstname = $facebook_user->first_name;
                $user->lastname = $facebook_user->last_name;
                $user->facebook_id = $facebook_user->id;
                $user->email = $facebook_user->email;

                try {
                    $user->save();

                    // as this is the first time the user has logged in, take them for a tour
                    $this->redirect('profile/gettingstarted');
                } catch (Exception $e) {
                    // TODO: Something went wrong database side or validation failed, not the users fault
                    print_r($e);
                    exit;
                }
            }

            $this->redirect('profile');
        }
    }

    public function action_facebooklogout()
    {
        $facebook = SociableFacebookAdapter::get_instance();
        if ($facebook->is_user_logged_in()) {
            $facebook->log_user_out_of_facebook();
        }
    }
}