<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\UserGroup;
use UserBundle\Form\Type\UserGroupType;

/**
 * Group controller.
 *
 * @Route("/admin/user-group")
 */
class GroupController extends Controller
{
    /**
     * Lists all UserGroup entities.
     *
     * @Route("/", name="admin_user_group")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:UserGroup')->findAll();
        
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a UserGroup entity.
     *
     * @Route("/{id}/show", name="admin_user_group_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(UserGroup $group)
    {
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_user_group_delete');

        return $this->render("UserBundle:Group:show.html.twig", array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new UserGroup entity.
     *
     * @Route("/new", name="admin_user_group_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $group = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $group);

        return $this->render("UserBundle:Group:new.html.twig", array(
            'group' => $group,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new UserGroup entity.
     *
     * @Route("/create", name="admin_user_group_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $group = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $group);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_user_group_show', array('id' => $group->getId())));
        }

        return $this->render("UserBundle:Group:new.html.twig", array(
            'group' => $group,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserGroup entity.
     *
     * @Route("/{id}/edit", name="admin_user_group_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(UserGroup $group)
    {
        $editForm = $this->createForm(UserGroupType::class, $group, array(
            'action' => $this->generateUrl('admin_user_group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_user_group_delete');

        return $this->render("UserBundle:Group:edit.html.twig", array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing UserGroup entity.
     *
     * @Route("/{id}/update", name="admin_user_group_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(UserGroup $group, Request $request)
    {
        $editForm = $this->createForm(UserGroupType::class, $group, array(
            'action' => $this->generateUrl('admin_user_group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_user_group_edit', array('id' => $group->getId())));
        }
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_user_group_delete');

        return $this->render("UserBundle:Group:edit.html.twig", array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserGroup entity.
     *
     * @Route("/{id}/delete", name="admin_user_group_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(UserGroup $group, Request $request)
    {
        $form = $this->createDeleteForm($group->getId(), 'admin_user_group_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user_group'));
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

}
