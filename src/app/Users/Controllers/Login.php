<?php

namespace App\Users\Controllers;



use App\Users\Validator;

class Login extends Base
{

	/**
	 * @var Validator
	 * @Inject
	 */
	protected $validator;


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
	    $this->notLoggedIn();

        //Check token

        $params = $this->request->getParsedBody();

        $this->validator->checkLoginRequest($params);

        //validate
        //set errors back if they are existing (in flash)
        //login
        //redirect

	    return '';
    }



}