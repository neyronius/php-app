<?php

namespace Neyronius\Base\Auth;

interface UserInterface
{

	public function isLoggedIn() : bool;

	public function getId() : string;

}