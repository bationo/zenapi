<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller
{
    public function recentsAction($limit, Request $request)
    {
        $comments = $this->getDoctrine()->getRepository("AdminBundle:Comment")->findActive($limit);

        return $this->render('comment/recents.html.twig', array(
            'comments' => $comments
        ));
    }
}
