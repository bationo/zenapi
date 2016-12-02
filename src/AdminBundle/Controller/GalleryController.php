<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Gallery;
use AdminBundle\Form\Type\GalleryType;

/**
 * Gallery controller.
 *
 * @Route("/admin/gallery")
 */
class GalleryController extends Controller
{
    /**
     * Lists all Gallery entities.
     *
     * @Route("/", name="admin_gallery")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:Gallery')->findAll();
        
        return $this->render('AdminBundle:gallery:index.html.twig', array(
            'entities'  => $entities,
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     * @Route("/{id}/show", name="admin_gallery_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Gallery $image)
    {
        $deleteForm = $this->createDeleteForm($image->getId(), 'admin_gallery_delete');

        return $this->render('AdminBundle:gallery:show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     * @Route("/new", name="admin_gallery_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $image = new Gallery();
        $form = $this->createForm(GalleryType::class, $image);

        return $this->render('AdminBundle:gallery:new.html.twig', array(
            'image' => $image,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     * @Route("/create", name="admin_gallery_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $image = new Gallery();
        $form = $this->createForm(GalleryType::class, $image);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_show', array('id' => $image->getId())));
        }

        return $this->render('AdminBundle:gallery:new.html.twig', array(
            'image'  => $image,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     * @Route("/{id}/edit", name="admin_gallery_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Gallery $image)
    {
        $editForm = $this->createForm(GalleryType::class, $image, array(
            'action' => $this->generateUrl('admin_gallery_update', array('id' => $image->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($image->getId(), 'admin_gallery_delete');

        return $this->render('AdminBundle:gallery:edit.html.twig', array(
            'image' => $image,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Gallery entity.
     *
     * @Route("/{id}/update", name="admin_gallery_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Gallery $image, Request $request)
    {
        $editForm = $this->createForm(GalleryType::class, $image, array(
            'action' => $this->generateUrl('admin_gallery_update', array('id' => $image->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_gallery_edit', array('id' => $image->getId())));
        }
        $deleteForm = $this->createDeleteForm($image->getId(), 'admin_gallery_delete');

        return $this->render('AdminBundle:gallery:edit.html.twig', array(
            'image'       => $image,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gallery entity.
     *
     * @Route("/{id}/delete", name="admin_gallery_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Gallery $gallery, Request $request)
    {
        $form = $this->createDeleteForm($gallery->getId(), 'admin_gallery_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gallery);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gallery'));
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
