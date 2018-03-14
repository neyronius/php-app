<?php

namespace App\Users\Controllers;


class Logout extends Base
{

	public function do()
	{
		if($this->auth->isLoggedIn()){
			$this->auth->logOutAndDestroySession();
		}

		$this->responseService->redirect('/');
	}
}