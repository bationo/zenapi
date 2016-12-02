<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\Proprietaire;
use UserBundle\Entity\User;
use UserBundle\Form\Type\ProprietaireType;
use UserBundle\Form\Type\InscriptionEntrepriseType;
use UserBundle\Form\Type\InscriptionParticulierType;



/**
 * Proprietaire controller.
 *
 * @Route("proprietaire")
 */
class ProprietaireController extends Controller
{
    /**
     * Lists all Proprietaire entities.
     *
     * @Route("/", name="proprietaire")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('UserBundle:User')->findAll();
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a Proprietaire entity.
     *
     * @Route("/{id}/show", name="proprietaire_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(User $proprietaire)
    {
        $deleteForm = $this->createDeleteForm($proprietaire->getId(), 'proprietaire_delete');

        return array(
            'user' => $proprietaire,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Proprietaire entity.
     *
     * @Route("/new/{type}", name="proprietaire_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($type)
    {
        $proprietaire = new User();
		if($type == "entreprise"){
			 $form = $this->createForm( InscriptionEntrepriseType::class, $proprietaire);
		}else{
			$form = $this->createForm( InscriptionParticulierType::class, $proprietaire);
		}
       

        return array(
            'proprietaire' => $proprietaire, "type" => $type , 
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Proprietaire entity.
     *
     * @Route("/create/{type}", name="proprietaire_create")
     * @Method("POST")
     * @Template("UserBundle:Proprietaire:new.html.twig")
     */
    public function createAction(Request $request , $type)
    {
                $proprietaire = new User();
		if($type == "entreprise"){
			 $form = $this->createForm( InscriptionEntrepriseType::class, $proprietaire );
		}else{
			$form = $this->createForm( InscriptionParticulierType::class, $proprietaire);
		}
		$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Proprietaire');
		$pass = $this->generer_mot_de_passe();
		$proprietaire->setPlainPassword($pass);
		
        if ($form->handleRequest($request)->isValid()) {
			
			
			
           

				$proprietaire->setUsername($proprietaire->getEmail()); 
				$proprietaire->setEnabled(true);
				$proprietaire->addGroup($group);
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($proprietaire);
				
				
         

            return $this->redirect($this->generateUrl('proprietaire_show', array('id' => $proprietaire->getId())));
        }

        return array(
            'proprietaire' => $proprietaire,  "type" => $type ,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Proprietaire entity.
     *
     * @Route("/{id}/edit", name="proprietaire_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(User $proprietaire)
    { 
		
		if($proprietaire->getProprietaire()->getEntreprise() != null){
			 
			  $editForm = $this->createForm(InscriptionEntrepriseType::class, $proprietaire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('proprietaire_update', array('id' => $proprietaire->getId()  )),
            'method' => 'PUT',
        ));
		
		}else{
			$editForm = $this->createForm(InscriptionParticulierType::class, $proprietaire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('proprietaire_update', array('id' => $proprietaire->getId()  )),
            'method' => 'PUT',
        ));
		}
		
		
       
        $deleteForm = $this->createDeleteForm($proprietaire->getId(), 'proprietaire_delete');
        return array(
            'proprietaire' => $proprietaire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Proprietaire entity.
     *
     * @Route("/{id}/update", name="proprietaire_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("UserBundle:Proprietaire:edit.html.twig")
     */
    public function updateAction(User $proprietaire, Request $request)
    {
       if($proprietaire->getProprietaire()->getEntreprise() != null){
			 
			  $editForm = $this->createForm(InscriptionEntrepriseType::class, $proprietaire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('proprietaire_update', array('id' => $proprietaire->getId() )),
            'method' => 'PUT',
        ));
		
		}else{
			$editForm = $this->createForm(InscriptionParticulierType::class, $proprietaire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('proprietaire_update', array('id' => $proprietaire->getId()  )),
            'method' => 'PUT',
        ));
		}
		
        if ($editForm->handleRequest($request)->isValid()) {
			
			
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('proprietaire_edit', array('id' => $proprietaire->getId())));
        }
        $deleteForm = $this->createDeleteForm($proprietaire->getId(), 'proprietaire_delete');

        return array(
            'proprietaire' => $proprietaire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Proprietaire entity.
     *
     * @Route("/{id}/delete", name="proprietaire_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Proprietaire $proprietaire, Request $request)
    {
        $form = $this->createDeleteForm($proprietaire->getId(), 'proprietaire_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proprietaire);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proprietaire'));
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
	
		protected function generer_mot_de_passe($nb_caractere = 6)
	{
			$mot_de_passe = "";
		   
			$chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
			$longeur_chaine = strlen($chaine);
		   
			for($i = 1; $i <= $nb_caractere; $i++)
			{
				$place_aleatoire = mt_rand(0,($longeur_chaine-1));
				$mot_de_passe .= $chaine[$place_aleatoire];
			}

			return $mot_de_passe;   
	}	

}
