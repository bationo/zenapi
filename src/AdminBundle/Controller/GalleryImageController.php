<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Gallery;
use AdminBundle\Entity\GalleryImage;
use AdminBundle\Form\Type\GalleryImageType;

/**
 * GalleryImage controller.
 *
 * @Route("/admin/gallery_image")
 */
class GalleryImageController extends Controller
{
    /**
     * Lists all GalleryImage entities.
     *
     * @Route("/{id}", name="admin_gallery_image", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function indexAction(Gallery $gallery)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AdminBundle:GalleryImage')->findByGallery($gallery);
        
        return $this->render('AdminBundle:galleryimage:index.html.twig', array(
            'gallery'  => $gallery,
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a GalleryImage entity.
     *
     * @Route("/{id}/show", name="admin_gallery_image_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(GalleryImage $image)
    {
        $deleteForm = $this->createDeleteForm($image->getId(), 'admin_gallery_image_delete');

        return $this->render('AdminBundle:galleryimage:show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new GalleryImage entity.
     *
     * @Route("/{id}/create", name="admin_gallery_image_create", requirements={"id"="\d+"})
     * @Method({"GET","POST"})
     */
    public function createAction(Gallery $gallery, Request $request)
    {
        $image = new GalleryImage();
        $image->setGallery($gallery);

        $form = $this->createForm(GalleryImageType::class, $image);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_image_show', array('id' => $image->getId())));
        }

        return $this->render('AdminBundle:galleryimage:new.html.twig', array(
            'image'   => $image,
            'gallery' => $gallery,
            'form'    => $form->createView(),
        ));
    }


    /**
     * Displays a form to update an existing TheatricalRelease entity.
     *
     * @Route("/{id}/update", name="admin_gallery_image_update", requirements={"id"="\d+"})
     * @Method({"GET","POST"})
     */
    public function updateAction(GalleryImage $image, Request $request)
    {
        $editForm = $this->createForm(GalleryImageType::class, $image, array(
            'action' => $this->generateUrl('admin_gallery_image_update', array('id' => $image->getId())),
            'method' => 'POST',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_gallery_image_update', array('id' => $image->getId())));
        }
        $deleteForm = $this->createDeleteForm($image->getId(), 'admin_gallery_image_delete');

        return $this->render('AdminBundle:galleryimage:edit.html.twig', array(
            'image'       => $image,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GalleryImage entity.
     *
     * @Route("/{id}/delete", name="admin_gallery_image_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(GalleryImage $galleryimage, Request $request)
    {
        $form = $this->createDeleteForm($galleryimage->getId(), 'admin_gallery_image_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($galleryimage);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gallery_image'));
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
