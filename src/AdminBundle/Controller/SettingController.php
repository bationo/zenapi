<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AdminBundle\Entity\Setting;
use AdminBundle\Form\Type\SettingType;

/**
 * Setting controller.
 *
 * @Route("/admin/settings")
 */
class SettingController extends Controller
{
    /**
     * Lists all Setting entities.
     *
     * @Route("/", name="admin_settings")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $setting = $em->getRepository('AdminBundle:Setting')->findOneById(1);

        if ($setting)
            return $this->redirect($this->generateUrl('admin_settings_edit', array('id' => $setting->getId())));
        else
            return $this->redirect($this->generateUrl('admin_settings_new'));
    }

    /**
     * Finds and displays a Setting entity.
     *
     * @Route("/{id}/show", name="admin_settings_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Setting $setting)
    {
        $deleteForm = $this->createDeleteForm($setting->getId(), 'admin_settings_delete');

        return $this->render('AdminBundle:setting:show.html.twig', array(
            'setting' => $setting,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Setting entity.
     *
     * @Route("/new", name="admin_settings_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $setting = new Setting();
        $form = $this->createForm(SettingType::class, $setting);

        return $this->render('AdminBundle:setting:new.html.twig', array(
            'setting' => $setting,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Setting entity.
     *
     * @Route("/create", name="admin_settings_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $setting = new Setting();
        $form = $this->createForm(SettingType::class, $setting);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_settings_edit', array('id' => $setting->getId())));
        }

        return $this->render('AdminBundle:setting:new.html.twig', array(
            'setting' => $setting,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Setting entity.
     *
     * @Route("/{id}/edit", name="admin_settings_edit", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function editAction(Setting $setting)
    {
        $editForm = $this->createForm(SettingType::class, $setting, array(
            'action' => $this->generateUrl('admin_settings_update', array('id' => $setting->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($setting->getId(), 'admin_settings_delete');

        return $this->render('AdminBundle:setting:edit.html.twig', array(
            'setting' => $setting,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Setting entity.
     *
     * @Route("/{id}/update", name="admin_settings_update", requirements={"id"="\d+"})
     * @Method("PUT")
     */
    public function updateAction(Setting $setting, Request $request)
    {
        $editForm = $this->createForm(SettingType::class, $setting, array(
            'action' => $this->generateUrl('admin_settings_update', array('id' => $setting->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_settings_edit', array('id' => $setting->getId())));
        }
        $deleteForm = $this->createDeleteForm($setting->getId(), 'admin_settings_delete');

        return $this->render('AdminBundle:setting:edit.html.twig', array(
            'setting' => $setting,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Setting entity.
     *
     * @Route("/{id}/delete", name="admin_settings_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Setting $setting, Request $request)
    {
        $form = $this->createDeleteForm($setting->getId(), 'admin_settings_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($setting);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_settings'));
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
