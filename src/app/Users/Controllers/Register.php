<?php

namespace App\Users\Controllers;


class Register extends Base
{

	/**
	 * Render login form
	 *
	 * @return string
	 */
	public function show()
	{
		$this->notLoggedIn();

		return $this->tpl->render('users::register', []);
	}

	/**
	 *
	 * POST
	 *
	 * @throws \Delight\Auth\AuthError
	 * @throws \Delight\Auth\InvalidEmailException
	 * @throws \Delight\Auth\InvalidPasswordException
	 * @throws \Delight\Auth\TooManyRequestsException
	 * @throws \Delight\Auth\UserAlreadyExistsException
	 */
	public function tryToRegister()
	{

		$email = $this->request->getQueryParams()['email'];
		$password = $this->request->getQueryParams()['password'];

		$this->auth->register($email, $password);

		$this->responseService->redirect('/login');
	}
}