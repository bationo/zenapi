<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Cast;
use FrontBundle\Form\Type\CastType;


/**
 * Front controller.
 *
 * @Route("/distribution")
 */
class CastController extends Controller
{
	/**
     * Cast homepage
     *
     * @Route("/", name="distribution")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $casting = $em->getRepository('AdminBundle:Cast')->findAll();

        return $this->render('cast/index.html.twig', array(
            'casting' => $casting
        ));
    }
}
