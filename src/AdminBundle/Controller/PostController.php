<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Post;
use AdminBundle\Form\Type\PostType;

/**
 * Post controller.
 *
 * @Route("/admin/posts")
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="admin_posts")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Post')->findAllByTag();

        return $this->render('AdminBundle:post:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}/show", name="admin_posts_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        $disapproveForm = $this->createCustomForm($post->getId(), 'admin_posts_trash', 'DELETE', 'disapprove');
        $deleteForm = $this->createDeleteForm($post->getId(), 'admin_posts_delete');

        return $this->render('AdminBundle:post:show.html.twig', array(
            'post'            => $post,
            'disapprove_form' => $disapproveForm->createView(),
            'delete_form'     => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="admin_posts_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $post = new Post();

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AdminBundle:Category')->findOneBySlug('article');
        if (!$category) $category = new \AdminBundle\Entity\Category();

        $form = $this->createForm(PostType::class, $post, array(
            'category' => $category,
        ));

        return $this->render('AdminBundle:post:new.html.twig', array(
            'post' => $post,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/create", name="admin_posts_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $post = new Post(); /*dump($post);die();*/
        $form = $this->createForm(PostType::class, $post);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_posts_show', array('id' => $post->getId())));
        }

        return $this->render('AdminBundle:post:new.html.twig', array(
            'post' => $post,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="admin_posts_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AdminBundle:Category')->findOneBySlug('article');
        if (!$category) $category = new \AdminBundle\Entity\Category();

        $editForm = $this->createForm(PostType::class, $post, array(
            'action' => $this->generateUrl('admin_posts_update', array('id' => $post->getId())),
            'method' => 'PUT',
            'category' => $category,
        ));
        $disapproveForm = $this->createCustomForm($post->getId(), 'admin_posts_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:post:edit.html.twig', array(
            'post' => $post,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}/update", name="admin_posts_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Post $post, Request $request)
    {
        $editForm = $this->createForm(PostType::class, $post, array(
            'action' => $this->generateUrl('admin_posts_update', array('id' => $post->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_posts_edit', array('id' => $post->getId())));
        }
        $disapproveForm = $this->createCustomForm($post->getId(), 'admin_posts_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:post:edit.html.twig', array(
            'post' => $post,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", name="admin_posts_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Post $post, Request $request)
    {
        $form = $this->createDeleteForm($post->getId(), 'admin_posts_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_posts'));
    }
    /**
     * Trash a Post entity.
     *
     * @Route("/{id}/trash", name="admin_posts_trash", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function trashAction(Post $post, Request $request)
    {
        $form = $this->createDeleteForm($post->getId(), 'admin_posts_trash');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trash_state = $em->getRepository('AdminBundle:State')->findOneBySlug('corbeille');
            $post->setState($trash_state);
            $em->persist($post);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_posts'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Create form
     *
     * @param integer                       $id
     * @param string                        $route
     * @param string                        $method
     * @return \Symfony\Component\Form\Form
     */
    protected function createCustomForm($id, $route, $method, $form_id)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => $form_id)))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod($method)
            ->getForm()
            ;
    }

}
