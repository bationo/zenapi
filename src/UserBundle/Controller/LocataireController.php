<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\Locataire;
use UserBundle\Entity\Proprietaire;
use UserBundle\Entity\User;
use UserBundle\Form\Type\InscriptionLocataireEntrepriseType;
use UserBundle\Form\Type\InscriptionLocataireParticulierType;

/**
 * Locataire controller.
 *
 * @Route("/locataire")
 */
class LocataireController extends Controller
{
    /**
     * Lists all Locataire entities.
     *
     * @Route("/", name="locataire")
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
     * Finds and displays a Locataire entity.
     *
     * @Route("/{id}/show", name="locataire_show")
     * @Template()
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user->getId(), 'locataire_delete');

        return array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Locataire entity.
     *
     * @Route("/new/{type}", name="locataire_new")
     * @Template()
     */
    public function newAction( $type)
    {
        
		
		$locataire = new User();
		if($type == "entreprise"){
			 $form = $this->createForm( InscriptionLocataireEntrepriseType::class, $locataire);
		}else{
			$form = $this->createForm( InscriptionLocataireParticulierType::class, $locataire);
		}
		
		

        return array(
            'locataire' => $locataire,
            'form'   => $form->createView(), 'type'  => $type
        );
    }

    /**
     * Creates a new Locataire entity.
     *
     * @Route("/create/{type}", name="locataire_create")
     * @Method("POST")
     * @Template("UserBundle:Locataire:new.html.twig")
     */
    public function createAction(Request $request , $type)
    {
		$locataire = new User();
		if($type == "entreprise"){
			 $form = $this->createForm( InscriptionLocataireEntrepriseType::class, $locataire);
		}else{
			$form = $this->createForm( InscriptionLocataireParticulierType::class, $locataire);
		}
		
		
		$group = $this->getDoctrine()->getManager()->getRepository('UserBundle:UserGroup')->findOneByName('Locataire');
		$pass = $this->generer_mot_de_passe();
		$locataire->setPlainPassword($pass);
		
		
		
        if ($form->handleRequest($request)->isValid()) {
            $pays =  $this->getDoctrine()->getManager()->getRepository('AdminBundle:Pays')->find($locataire->getPays()->getNom()->getId());
			
				$locataire->setUsername($locataire->getEmail()); 
				$locataire->setEnabled(true);
				$locataire->addGroup($group);
				$locataire->setPays($pays);
				
				$userManager = $this->get('fos_user.user_manager');
				$userManager->updateUser($locataire);
				echo 3;
				die();
			}

        return array(
            'locataire' => $locataire,
            'form'   => $form->createView(), 'type'  => $type
        );
    }

    /**
     * Displays a form to edit an existing Locataire entity.
     *
     * @Route("/{id}/edit", name="locataire_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(User $locataire)
    {
		
		if($locataire->getLocataire()->getEntreprise() != null){
			 $editForm = $this->createForm(InscriptionLocataireEntrepriseType::class, $locataire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('locataire_update', array('id' => $locataire->getId())),
            'method' => 'PUT',
        ));
		}else{
			 $editForm = $this->createForm(InscriptionLocataireParticulierType::class, $locataire, array(
            'action' => $this->generateUrl('locataire_update', array('id' => $locataire->getId())),
            'method' => 'PUT',
        ));
		}
		
		
        $deleteForm = $this->createDeleteForm($locataire->getId(), 'locataire_delete');

        return array(
            'locataire' => $locataire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Locataire entity.
     *
     * @Route("/{id}/update", name="locataire_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("UserBundle:Locataire:edit.html.twig")
     */
    public function updateAction(User $locataire, Request $request)
    {
        if($locataire->getLocataire()->getEntreprise() != null){
			 $editForm = $this->createForm(InscriptionLocataireEntrepriseType::class, $locataire, array( "passwordRequired" => false , 
            'action' => $this->generateUrl('locataire_update', array('id' => $locataire->getId())),
            'method' => 'PUT',
        ));
		}else{
			 $editForm = $this->createForm(InscriptionLocataireParticulierType::class, $locataire, array(
            'action' => $this->generateUrl('locataire_update', array('id' => $locataire->getId())),
            'method' => 'PUT',
        ));
		}
		
		
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('locataire_edit', array('id' => $locataire->getId())));
        }
        $deleteForm = $this->createDeleteForm($locataire->getId(), 'locataire_delete');

        return array(
            'locataire' => $locataire,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Locataire entity.
     *
     * @Route("/{id}/delete", name="locataire_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(User $locataire, Request $request)
    {
        $form = $this->createDeleteForm($locataire->getId(), 'locataire_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($locataire);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('locataire'));
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
