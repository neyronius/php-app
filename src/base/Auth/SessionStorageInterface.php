<?php

namespace Neyronius\Base\Auth;

interface SessionStorageInterface
{

	public function setUserId(string $id);


	public function getUserId() : string;

}
