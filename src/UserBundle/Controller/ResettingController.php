<?php

namespace UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ResettingController as BaseController;
 
// Surcharge de la classe FOS\UserBundle\Controller\ResettingController
class ResettingController extends BaseController {
 
    // Surcharge de l'action requestAction()
    public function requestAction() {
        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;
 
        /*
         * Teste de la route de provenance
         * Si route Backoffice request : redirection vers le template de mot de passe oublié de l'administration
         * Sinon si route FrontOffice request : redirection vers le template de mot de passe oublié du Frontoffice (l'original de FOSUserBundle)
         */
        if ($requestAttributes->get('_route') == 'admin_resetting_request') {
            $template = sprintf('AdminBundle:Resetting:request.html.twig');
        } else {
            $template = sprintf('Resetting/request.html.twig');
            //$template = sprintf('Resetting/request.html.twig');
        }
 
        return $this->container->get('templating')->renderResponse($template);
    }

    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;

        if (null === $user) {
            if ($requestAttributes->get('_route') == 'admin_resetting_send_email') {
                $template = sprintf('AdminBundle:Resetting:request.html.twig');
            } else {
                $template = sprintf('Resetting/request.html.twig');
                //$template = sprintf('Resetting/request.html.twig');
            }

            return $this->container->get('templating')->renderResponse($template, array(
                'invalid_username' => $username
            ));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            if ($requestAttributes->get('_route') == 'admin_resetting_send_email') {
                $template = sprintf('AdminBundle:Resetting:passwordAlreadyRequested.html.twig');
            } else {
                $template = sprintf('Resetting/passwordAlreadyRequested.html.twig');
                //$template = sprintf('Resetting/passwordAlreadyRequested.html.twig');
            }

            return $this->container->get('templating')->renderResponse($template);
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        if ($requestAttributes->get('_route') == 'admin_resetting_send_email') {
            $this->get('fos_user.mailer')->sendResettingAdminEmailMessage($user);
        } else {
            $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
        }
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        if ($requestAttributes->get('_route') == 'admin_resetting_send_email') {
            return new RedirectResponse($this->generateUrl('admin_resetting_check_email',
                array('email' => $this->getObfuscatedEmail($user))
            ));
        } else {
            return new RedirectResponse($this->generateUrl('fos_user_resetting_check_email',
                array('email' => $this->getObfuscatedEmail($user))
            ));
        }
    }

    public function checkEmailAction(Request $request)
    {
        $email = $request->query->get('email');

        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;

        if ($requestAttributes->get('_route') == 'admin_resetting_check_email') {
            $template = sprintf('AdminBundle:Resetting:checkEmail.html.twig');

            if (empty($email)) {
                // the user does not come from the sendEmail action
                return new RedirectResponse($this->generateUrl('admin_resetting_request'));
            }
        } else {
            $template = sprintf('Resetting/checkEmail.html.twig');
            //$template = sprintf('Resetting/checkEmail.html.twig');

            if (empty($email)) {
                // the user does not come from the sendEmail action
                return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
            }
        }

        return $this->container->get('templating')->renderResponse($template, array(
            'email' => $email,
        ));
    }

    public function resetAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $requestAttributes = $this->container->get('request_stack')->getCurrentRequest()->attributes;

        if ($requestAttributes->get('_route') == 'admin_resetting_reset') {
            $template = sprintf('AdminBundle:Resetting:reset.html.twig');

            $url = $this->generateUrl('admin_profile_show');
        } else {
            $template = sprintf('Resetting/reset.html.twig');
            //$template = sprintf('Resetting/reset.html.twig');

            $url = $this->generateUrl('fos_user_profile_show');
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                //$url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->container->get('templating')->renderResponse($template, array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}