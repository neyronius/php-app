<?php

namespace App\Users\Controllers;



class Login extends Base
{


    /**
     * Render login form
     *
     * @return string
     */
    public function show()
    {
        $this->notLoggedIn();


        return $this->tpl->render('users::login', []);
    }

    /**
     * Check sended data from login form
     */
    public function tryToLogin()
    {
        //Check token

        $params = $this->request->getQueryParams();

        //validate
        //set errors back if they are existing (in flash)
        //login
        //redirect

    }



}