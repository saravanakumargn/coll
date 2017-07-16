<?php

namespace UserBundle\Core\Listener;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\SecurityContext;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface {

    protected $router;
    protected $userManager;
    private $security;

    public function __construct(Router $router, UserManagerInterface $userManager, SecurityContext $security) {
        $this->router = $router;
        $this->userManager = $userManager;
        $this->security = $security;
    }

    public function onLogoutSuccess(Request $request) {
        // redirect the user to where they were before the login process begun.
        if (is_object($this->security->getToken())) {
            $user = $this->security->getToken()->getUser();
            if ($user instanceof UserInterface) {
                $user->setUserLogged(false);
                $this->userManager->updateUser($user);
            }
        }

        $response = new RedirectResponse($this->router->generate('homepage'));
        return $response;
    }

}
