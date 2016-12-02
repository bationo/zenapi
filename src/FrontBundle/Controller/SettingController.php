<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function titleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return new Response($setting->getTitle());
    }

    public function keywordsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return new Response($setting->getKeywords());
    }

    public function descriptionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return new Response($setting->getDescription());
    }

    public function trailerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return new Response($setting->getTrailer());
    }

    /**
     * About page
     *
     * @Route("/a-propos", name="about")
     * @Method("GET")
     */
    public function aboutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return $this->render('default/about.html.twig', array(
            'setting' => $setting
        ));
    }

    public function menuImageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return new Response($setting->getMenuImageWebPath());
    }

    public function backgroundImagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        return $this->render('default/background.html.twig', array(
            'setting' => $setting
        ));
    }
}
