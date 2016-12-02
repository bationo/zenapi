<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Front controller.
 *
 * @Route("/programme")
 */
class TheatricalReleaseController extends Controller
{
	/**
     * TheatricalRelease homepage
     *
     * @Route("/", name="programme")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $theatricalReleases = $em->getRepository('AdminBundle:TheatricalRelease')->findBy(array(), array('dateTime' => 'asc'));

        return $this->render('theatricalrelease/index.html.twig', array(
            'theatricalreleases' => $theatricalReleases
        ));
    }
}
