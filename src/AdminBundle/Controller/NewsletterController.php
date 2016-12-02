<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Newsletter;

/**
 * Newsletter controller.
 *
 * @Route("/admin/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * Lists all Newsletter entities.
     *
     * @Route("/", name="admin_newsletter")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Newsletter')->findAll();

        return $this->render('AdminBundle:newsletter:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Newsletter entity.
     *
     * @Route("/{id}/show", name="admin_newsletter_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Newsletter $newsletter)
    {
        return $this->render('AdminBundle:newsletter:show.html.twig', array(
            'newsletter' => $newsletter,
        ));
    }

}
