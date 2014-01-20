<?php

namespace Wn\UserBundle\Service;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBUndle\Routing\Router;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
	protected $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function onLogoutSuccess(Request $request)
	{
		//$referer_url = $request->headers->get('referer');
		//$response    = new RedirectResponse($referer_url);
		$response    = new RedirectResponse($this->router->generate('wn_blog_index'));
		return $response;
	}
}