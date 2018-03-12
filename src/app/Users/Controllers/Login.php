<?php

namespace App\Users\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

class Login
{

	/**
	 * @Inject
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 * @Inject
	 * @var ResponseInterface
	 */
	//protected $response;

	public function show()
	{
		//$this->response->getBody()->write("Login.Show");

		//return $this->response;

		return 'Test';
	}

	public function tryToLogin()
	{

	}

}