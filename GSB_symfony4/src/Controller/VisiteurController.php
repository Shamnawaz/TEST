<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\Extension\Core\Type\PasswordType ;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType ;
use Symfony\Component\Form\Extension\Core\Type\ResetType ;



class VisiteurController extends AbstractController
{
    public function index(Request $requete)
    {
		

		$form = $this->createFormBuilder(array())
					->add('login' , TextType::class)
					->add('password', PasswordType::class)
					->add('Se connecter', SubmitType::class)
					->getForm() ;
					
		$request = Request::createFromGlobals() ;		
		$form->handleRequest( $request ) ;
		$session = $requete->getSession();
                
		
					
		if($form->isSubmitted() && $form->isValid() ) {
                    
			$data = $form->getData();
			$bd = new \PDO('mysql:host=localhost;dbname=GSB' , 'developpeur' , 'azerty');
		
			$resultat = $bd->prepare('select id, nom, prenom, login, mdp from Visiteur where login = :login and mdp = :mdp');
                        $resultat->bindParam(':login' , $data['login']);
                        $resultat->bindParam(':mdp' , $data['password']);
		
			$resultat->execute();
			
                        
			
			if($resultat->rowCount() == 1) {
				
				$e = $resultat->fetch(\PDO::FETCH_ASSOC);
                               
                            
                                
                                if( $e['login'] == $data['login'] and $e['mdp'] == $data['password'] ){
                                                                        
                                                                        
                                    $session->set('id', $e['id']);
                                    $session->set('nom', $e['nom']);
                                    $session->set('prenom', $e['prenom']);
                                    $session->set('login', $data['login']);
                                    $session->set('mdp', $data['login']);
                                     
                                    
                                    
                                }
				
				return $this->render('menu_v/index.html.twig' , [
				'controller_name' => 'AccueilController',
				]);
			}	
				

			

			}
		
        return $this->render('visiteur/index.html.twig', [
            'formulaire' => $form->createView(), 
        ]);
    }
    

		
		
		
}

