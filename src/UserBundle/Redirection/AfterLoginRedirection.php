<?php
 
namespace UserBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
 
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
 
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
 
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess( Request $request, TokenInterface $token)
    {
		 $session = $request->getSession();
        // On récupère la liste des rôles d'un utilisateur
        $roles = $token->getRoles();
        
        // On transforme le tableau d'instance en tableau simple
        $rolesTab = array_map(function($role){ 
          return $role->getRole(); 
        
        }, $roles);
		
        if (in_array('ROLE_PRO', $rolesTab, true)){
			  $redirection = new RedirectResponse($this->router->generate('homepro'));
        // sinon il s'agit d'un membre
		}else{
			$referer = $session->get("_security.main.target_path"); 
			
			 
			 
			 if(empty($referer)) {		
			 $redirection = new RedirectResponse($this->router->generate('mon_compte'));	
			 }else{			
			 		$redirection = new RedirectResponse($referer);
			 
			 }
			
		}
        
        
          
        
				
      
 
        return $redirection;
    }
}