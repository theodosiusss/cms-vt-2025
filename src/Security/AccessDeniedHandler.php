<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Routing\RouterInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(private RouterInterface $router,private Security $security) {}

    public function handle(Request $request, AccessDeniedException $exception) : Response
    {
        if($this->security->getUser()){
            return new RedirectResponse($this->router->generate('user_welcome'));

        }
        return new RedirectResponse($this->router->generate('app_login'));
    }
}
