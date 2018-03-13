<?php

namespace App\Users\Controllers;

use Aura\Router\RouterContainer;
use Delight\Auth\Auth;
use League\Plates\Engine;

use Neyronius\Base\Controllers\Base;
use Neyronius\Base\Http\ResponseService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;


class Login extends Base
{
    /**
     * @Inject
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     *
     * @Inject
     * @var Engine
     */
    protected $tpl;


    /**
     * Auth service
     *
     * @Inject
     * @var Auth
     */
    protected $auth;

    /**
     * Response Service Helper
     * Includes all direct operations with response
     *
     * @Inject
     * @var ResponseService
     */
    protected $responseService;

    /**
     *
     *
     * @Inject
     * @var RouterContainer
     */
    protected $routerContainer;

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

    public function tryToLogin()
    {

    }

    /**
     * Check if the user is logged in. If yes, then redirect to home
     *
     * @throws \Aura\Router\Exception\RouteNotFound
     */
    protected function notLoggedIn()
    {
        if ($this->auth->isLoggedIn()) {
            $this->responseService->redirect($this->routerContainer->getGenerator()->generate('home'));
        }
    }

}