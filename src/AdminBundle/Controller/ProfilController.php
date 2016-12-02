<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ES\UserBundle\Entity\User as Profil;
use ES\UserBundle\Form\Type\UserType as ProfilType;
use ES\AdminBundle\Form\Type\UserProfilFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Profil controller.
 *
 * @Route("/admin/cvtheque")
 */
class ProfilController extends Controller
{
    /**
     * Lists all Profil entities.
     *
     * @Route("/", name="es_admin_profil")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserProfilFilterType());
        
        if (!is_null($response = $this->saveFilter($form, 'profil', 'es_admin_profil'))) {
            return $response;
        }

        $qb = $em->getRepository('ESUserBundle:User')->createQueryBuilder('u');

        $qb
            ->select('u, p')
            ->innerJoin('u.profil', 'p')
            ->andWhere($qb->expr()->isNotNull('u.profil'))
            ->groupBy('p.id')
            ->orderBy('p.nom', 'ASC')
        ;

        $qbUpdater = $this->get('lexik_form_filter.query_builder_updater');

        // set the joins
        $qbUpdater->setParts(array(
            '__root__' => 'u',
            'u.profil' => 'p',
        ));

        $qbUpdater->addFilterConditions($form, $qb);

        $this->addQueryBuilderSort($qb, 'profil');
        $paginator = $this->get('knp_paginator')->paginate($qb, $this->getRequest()->query->get('page', 1), 20);
        
        return array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Profil entity.
     *
     * @Route("/{id}/show", name="es_admin_profil_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Profil $user)
    {
        $deleteForm = $this->createDeleteForm($user->getId(), 'es_admin_profil_delete');

        return array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Profil entity.
     *
     * @Route("/new", name="es_admin_profil_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $profil = new Profil();
        $form = $this->createForm(new ProfilType(), $profil);

        return array(
            'profil' => $profil,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Profil entity.
     *
     * @Route("/create", name="es_admin_profil_create")
     * @Method("POST")
     * @Template("RHProfilBundle:Profil:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $profil = new Profil();
        $form = $this->createForm(new ProfilType(), $profil);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            return $this->redirect($this->generateUrl('es_admin_profil_show', array('id' => $profil->getId())));
        }

        return array(
            'profil' => $profil,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Profil entity.
     *
     * @Route("/{id}/edit", name="es_admin_profil_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Profil $profil)
    {
        $editForm = $this->createForm(new ProfilType(), $profil, array(
            'action' => $this->generateUrl('es_admin_profil_update', array('id' => $profil->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($profil->getId(), 'es_admin_profil_delete');

        return array(
            'profil' => $profil,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Profil entity.
     *
     * @Route("/{id}/update", name="es_admin_profil_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("RHProfilBundle:Profil:edit.html.twig")
     */
    public function updateAction(Profil $profil, Request $request)
    {
        $editForm = $this->createForm(new ProfilType(), $profil, array(
            'action' => $this->generateUrl('es_admin_profil_update', array('id' => $profil->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('es_admin_profil_edit', array('id' => $profil->getId())));
        }
        $deleteForm = $this->createDeleteForm($profil->getId(), 'es_admin_profil_delete');

        return array(
            'profil' => $profil,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="es_admin_profil_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('profil', $field, $type);

        return $this->redirect($this->generateUrl('es_admin_profil'));
    }

    /**
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set('sort.' . $name, array('field' => $field, 'type' => $type));
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Save filters
     *
     * @param  FormInterface $form
     * @param  string        $name   route/entity name
     * @param  string        $route  route name, if different from entity name
     * @param  array         $params possible route parameters
     * @return Response
     */
    protected function saveFilter(FormInterface $form, $name, $route = null, array $params = null)
    {
        $request = $this->getRequest();
        $url = $this->generateUrl($route ?: $name, is_null($params) ? array() : $params);
        if ($request->query->has('submit-filter') && $form->handleRequest($request)->isValid()) {
            $request->getSession()->set('filter.' . $name, $request->query->get($form->getName()));

            return $this->redirect($url);
        } elseif ($request->query->has('reset-filter')) {
            $request->getSession()->set('filter.' . $name, null);

            return $this->redirect($url);
        }
    }

    /**
     * Filter form
     *
     * @param  FormInterface                                       $form
     * @param  QueryBuilder                                        $qb
     * @param  string                                              $name
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    protected function filter(FormInterface $form, QueryBuilder $qb, $name)
    {
        if (!is_null($values = $this->getFilter($name))) {
            if ($form->submit($values)->isValid()) {
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $qb);
            }
        }

        // possible sorting
        $this->addQueryBuilderSort($qb, $name);
        return $this->get('knp_paginator')->paginate($qb, $this->getRequest()->query->get('page', 1), 20);
    }

    /**
     * Get filters from session
     *
     * @param  string $name
     * @return array
     */
    protected function getFilter($name)
    {
        return $this->getRequest()->getSession()->get('filter.' . $name);
    }

    /**
     * Deletes a Profil entity.
     *
     * @Route("/{id}/delete", name="es_admin_profil_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Profil $profil, Request $request)
    {
        $form = $this->createDeleteForm($profil->getId(), 'es_admin_profil_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profil);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('es_admin_profil'));
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
