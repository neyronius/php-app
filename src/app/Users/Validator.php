<?php
/**
 * Created by PhpStorm.
 * User: neyronius
 * Date: 27.03.2018
 * Time: 23:14
 */

namespace App\Users;

use Neyronius\Base\Assert;

class Validator
{

	/**
	 *
	 * @param array $request
	 */
	public function checkLoginRequest(array $request)
	{
		Assert::keyExists($request, 'email');
		Assert::keyExists($request, 'passwort');

		Assert::string($request['email']);
	}


}