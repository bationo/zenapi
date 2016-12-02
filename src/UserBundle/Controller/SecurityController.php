<?php

namespace UserBundle\Controller;
 
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
 
// Surcharge de la classe FOS\UserBundle\Controller\SecurityController
class SecurityController extends BaseController {
 
    // Surcharge de l'action renderLogin()
    public function renderLogin(array $data) {
        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;
 
        /*
         * Teste de la route de provenance
         * Si route Backoffice login : redirection vers le template de connexion de l'administration
         * Sinon si route FrontOffice login : redirection vers le template de connexion du Frontoffice (l'original de FOSUserBundle)
         */
        if ($requestAttributes->get('_route') == 'admin_security_login') {
            $template = sprintf('AdminBundle:Security:login.html.twig');
        } else {
            //$template = sprintf('FOSUserBundle:Security:login.html.twig');
            $template = sprintf('Security/login.html.twig');
        }
 
        return $this->container->get('templating')->renderResponse($template, $data);
    }
 
}