<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Front controller.
 *
 * @Route("/videos")
 */
class GalleryVideoController extends Controller
{
	/**
     * GalleryVideo homepage
     *
     * @Route("/", name="videos")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $videos = $em->getRepository('AdminBundle:GalleryVideo')->findAll();

        return $this->render('galleryvideo/index.html.twig', array(
            'videos' => $videos
        ));
    }
}
