<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Category;
use AdminBundle\Form\Type\CategoryType;

/**
 * Category controller.
 *
 * @Route("/admin/categories")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_categories")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Category')->findAll();
        
        return $this->render('AdminBundle:category:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="admin_categories_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category->getId(), 'admin_categories_delete');

        return $this->render('AdminBundle:category:show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="admin_categories_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        return $this->render('AdminBundle:category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="admin_categories_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_categories_show', array('id' => $category->getId())));
        }

        return $this->render('AdminBundle:category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_categories_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Category $category)
    {
        $editForm = $this->createForm(CategoryType::class, $category, array(
            'action' => $this->generateUrl('admin_categories_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($category->getId(), 'admin_categories_delete');

        return $this->render('AdminBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="admin_categories_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Category $category, Request $request)
    {
        $editForm = $this->createForm(CategoryType::class, $category, array(
            'action' => $this->generateUrl('admin_categories_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_categories_edit', array('id' => $category->getId())));
        }
        $deleteForm = $this->createDeleteForm($category->getId(), 'admin_categories_delete');

        return $this->render('AdminBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_categories_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Category $category, Request $request)
    {
        $form = $this->createDeleteForm($category->getId(), 'admin_categories_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_categories'));
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
