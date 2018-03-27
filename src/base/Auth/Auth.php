<?php
/**
 * Created by PhpStorm.
 * User: neyronius
 * Date: 20.03.2018
 * Time: 23:31
 */

namespace Neyronius\Base\Auth;


class Auth implements AuthInterface {


	protected $sessionStorage;

	public function login(): bool {
		// TODO: Implement login() method.
	}

	public function logout() {
		// TODO: Implement logout() method.
	}

	public function isLoggedIn(): bool {
		// TODO: Implement isLoggedIn() method.
		return false;
	}

	public function getCurrentUser(): UserInterface {
		// TODO: Implement getCurrentUser() method.
	}

}