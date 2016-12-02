<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Front controller.
 *
 * @Route("/photos")
 */
class GalleryController extends Controller
{
	/**
     * GalleryImage homepage
     *
     * @Route("/", name="photos")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('AdminBundle:Gallery')->findAll();

        return $this->render('gallery/index.html.twig', array(
            'albums' => $albums
        ));
    }
}
