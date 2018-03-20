<?php

namespace Neyronius\Base\Auth;

interface AuthInterface
{

	public function login() : bool;

	public function logout();

	public function isLoggedIn() : bool;

	public function getCurrentUser() : UserInterface;
}