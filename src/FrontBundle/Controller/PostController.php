<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Post;
use AdminBundle\Entity\Comment;
use FrontBundle\Form\Type\CommentType;


/**
 * Front controller.
 *
 * @Route("/actualite")
 */
class PostController extends Controller
{
	/**
     * Post homepage
     *
     * @Route("/", name="post")
     * @Method("GET")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Post')->findActiveByTag();

        return $this->render('post/index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * Post page
     *
     * @Route("/{slug}-{id}", name="post_show", requirements={"slug"="[a-zA-Z0-9\-_\/]+", "id"="\d+"})
     * @Method({"GET", "POST"})
     */
    public function showAction($slug, $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AdminBundle:Post')->findOneById($id);

        $comments = $em->getRepository('AdminBundle:Comment')->findByPost($post->getId());

        $comment = new Comment();
        //$waited_state = $em->getRepository('AdminBundle:State')->findOneBySlug('en-attente-de-relecture');
        $published_state = $em->getRepository('AdminBundle:State')->findOneBySlug('publie');
        $comment->setState($published_state);
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);

        if ($form->handleRequest($request)->isValid()) {

            $com_id = $form->get('comment')->getData();

            if ($com_id != '') {
                $comment_parent = $em->getRepository('AdminBundle:Comment')->findOneById($com_id);
                if ($comment_parent) $comment->setComment($comment_parent);
            }

            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('comment', ' Il est attente de relecture.');

            return $this->redirect($this->generateUrl('post_show', array(
                'slug' => $post->getSlug(),
                'id'   => $post->getId()
            )));
        }

        return $this->render('post/show.html.twig', array(
            'post'     => $post,
            'comment'  => $comment,
            'comments' => $comments,
            'form'     => $form->createView()
        ));
    }
}
