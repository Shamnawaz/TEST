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
#			$b1 = $sql->fetch(\PDO::FETCH_ASSOC);
#			$sql-> bindParam(':mois', $sprintf);


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
		
			$sql = 'select id , nom from Visiteur where login = :login and mdp = :mdp' ;
		
			$resultat = $bd->prepare($sql);
		
			$resultat->execute([':login' => $data['login'],
			':mdp' => $data['password']
			]);
			
			$session->set('id' , $data['login']);

			
			if($resultat->rowCount() == 1) {
				
				$e = $resultat->fetch();
				
				return $this->render('menu_v/index.html.twig' , [
				'controller_name' => 'AccueilController',
				]);
			}	
				

			

			}			
		
        return $this->render('visiteur/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
    

		
		
		
}

