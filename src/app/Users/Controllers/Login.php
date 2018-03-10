<?php

namespace App\Users\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

class Login
{

	/**
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 * @var ResponseInterface
	 */
	protected $response;

	public function show()
	{
		$this->response->getBody()->write("Login.Show");

		return $this->response;
	}

	public function tryToLogin()
	{

	}

}