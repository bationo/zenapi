<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\SubCategory;
use AdminBundle\Form\Type\SubCategoryType;

/**
 * SubCategory controller.
 *
 * @Route("/admin/sub-categories")
 */
class SubCategoryController extends Controller
{
    /**
     * Finds and displays a SubCategory entity.
     *
     * @Route("/{id}/show", name="admin_sub-categories_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(SubCategory $subcategory)
    {
        $deleteForm = $this->createDeleteForm($subcategory->getId(), 'admin_sub-categories_delete');

        return $this->render('AdminBundle:subcategory:show.html.twig', array(
            'subcategory' => $subcategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SubCategory entity.
     *
     * @Route("/{id}/edit", name="admin_sub-categories_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(SubCategory $subcategory)
    {
        $editForm = $this->createForm(SubCategoryType::class, $subcategory, array(
            'action' => $this->generateUrl('admin_sub-categories_update', array('id' => $subcategory->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($subcategory->getId(), 'admin_sub-categories_delete');

        return $this->render('AdminBundle:subcategory:edit.html.twig', array(
            'subcategory' => $subcategory,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing SubCategory entity.
     *
     * @Route("/{id}/update", name="admin_sub-categories_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(SubCategory $subcategory, Request $request)
    {
        $editForm = $this->createForm(SubCategoryType::class, $subcategory, array(
            'action' => $this->generateUrl('admin_sub-categories_update', array('id' => $subcategory->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_sub-categories_edit', array('id' => $subcategory->getId())));
        }
        $deleteForm = $this->createDeleteForm($subcategory->getId(), 'admin_sub-categories_delete');

        return $this->render('AdminBundle:subcategory:edit.html.twig', array(
            'subcategory' => $subcategory,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Lists all SubCategory entities.
     *
     * @Route("/{slug}", name="admin_sub-categories", requirements={"slug"="[a-zA-Z0-9\-_\/]+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:SubCategory')->findByCategorySlug($slug);

        $subcategory = new SubCategory();
        $category = $em->getRepository('AdminBundle:Category')->findOneBySlug($slug);
        if (!$category) $category = new \AdminBundle\Entity\Category();
        $subcategory->setCategory($category);

        $form = $this->createForm(SubCategoryType::class, $subcategory, array(
            'category' => $category,
        ));

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sub-categories', array('slug' => $form->get('slug')->getData())));
        }

        return $this->render('AdminBundle:subcategory:index.html.twig', array(
            'entities'    => $entities,
            'subcategory' => $subcategory,
            'form'        => $form->createView(),
        ));
    }

    /**
     * Deletes a SubCategory entity.
     *
     * @Route("/{id}/delete", name="admin_sub-categories_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(SubCategory $subcategory, Request $request)
    {
        $form = $this->createDeleteForm($subcategory->getId(), 'admin_sub-categories_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subcategory);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sub-categories'));
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
