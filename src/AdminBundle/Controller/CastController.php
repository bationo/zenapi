<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\Cast;
use AdminBundle\Form\Type\CastType;

/**
 * Cast controller.
 *
 * @Route("/admin/distribution")
 */
class CastController extends Controller
{
    /**
     * Lists all Cast entities.
     *
     * @Route("/", name="admin_distribution")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Cast')->findAll();
        
        return $this->render('AdminBundle:cast:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Cast entity.
     *
     * @Route("/{id}/show", name="admin_distribution_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Cast $cast)
    {
        $disapproveForm = $this->createCustomForm($cast->getId(), 'admin_distribution_trash', 'DELETE', 'disapprove');
        $deleteForm = $this->createDeleteForm($cast->getId(), 'admin_distribution_delete');

        return $this->render('AdminBundle:cast:show.html.twig', array(
            'cast'            => $cast,
            'disapprove_form' => $disapproveForm->createView(), 
            'delete_form'     => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Cast entity.
     *
     * @Route("/new", name="admin_distribution_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $cast = new Cast();
        $form = $this->createForm(CastType::class, $cast);

        return $this->render('AdminBundle:cast:new.html.twig', array(
            'cast' => $cast,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Cast entity.
     *
     * @Route("/create", name="admin_distribution_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $cast = new Cast();
        $form = $this->createForm(CastType::class, $cast);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cast);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_distribution_show', array('id' => $cast->getId())));
        }

        return $this->render('AdminBundle:cast:new.html.twig', array(
            'cast' => $cast,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cast entity.
     *
     * @Route("/{id}/edit", name="admin_distribution_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Cast $cast)
    {
        $editForm = $this->createForm(CastType::class, $cast, array(
            'action' => $this->generateUrl('admin_distribution_update', array('id' => $cast->getId())),
            'method' => 'PUT',
        ));
        $disapproveForm = $this->createCustomForm($cast->getId(), 'admin_distribution_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:cast:edit.html.twig', array(
            'cast' => $cast,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Edits an existing Cast entity.
     *
     * @Route("/{id}/update", name="admin_distribution_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Cast $cast, Request $request)
    {
        $editForm = $this->createForm(CastType::class, $cast, array(
            'action' => $this->generateUrl('admin_distribution_update', array('id' => $cast->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_distribution_edit', array('id' => $cast->getId())));
        }
        $disapproveForm = $this->createCustomForm($cast->getId(), 'admin_distribution_trash', 'DELETE', 'disapprove');

        return $this->render('AdminBundle:cast:edit.html.twig', array(
            'cast' => $cast,
            'edit_form'   => $editForm->createView(),
            'disapprove_form' => $disapproveForm->createView(),
        ));
    }

    /**
     * Trash a Cast entity.
     *
     * @Route("/{id}/trash", name="admin_distribution_trash", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function trashAction(Cast $cast, Request $request)
    {
        $form = $this->createDeleteForm($cast->getId(), 'admin_distribution_trash');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trash_state = $em->getRepository('AdminBundle:State')->findOneBySlug('corbeille');
            $cast->setState($trash_state);
            $em->persist($cast);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_distribution'));
    }

    /**
     * Deletes a Cast entity.
     *
     * @Route("/{id}/delete", name="admin_distribution_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Cast $cast, Request $request)
    {
        $form = $this->createDeleteForm($cast->getId(), 'admin_distribution_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cast);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_distribution'));
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
