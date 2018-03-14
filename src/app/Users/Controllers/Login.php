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

    public function tryToLogin()
    {

    }



}