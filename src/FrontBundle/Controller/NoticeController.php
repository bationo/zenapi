<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Notice;
use FrontBundle\Form\Type\NoticeType;


/**
 * Front controller.
 *
 * @Route("/notice")
 */
class NoticeController extends Controller
{
	/**
     * Notice homepage
     *
     * @Route("/", name="notice")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $notices = $em->getRepository('AdminBundle:Notice')->findAll();

        $notice = new Notice();
        $waited_state = $em->getRepository('AdminBundle:State')->findOneBySlug('en-attente-de-relecture');
        $notice->setState($waited_state);

        $form = $this->createForm(NoticeType::class, $notice);

        if ($form->handleRequest($request)->isValid()) {

            $em->persist($notice);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre avis a bien été enregistré. Il est attente de relecture.');

            return $this->redirect($this->generateUrl('notice'));
        }

        return $this->render('notice/index.html.twig', array(
            'notices' => $notices,
            'form'     => $form->createView()
        ));
    }

    public function bestsAction($limit, Request $request)
    {
        $notices = $this->getDoctrine()->getRepository("AdminBundle:Notice")->findBest($limit);
        
        return $this->render('notice/bests.html.twig', array('notices' => $notices, 'limit' => $limit));
    }
}
