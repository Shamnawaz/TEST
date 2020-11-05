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
use Symfony\Component\Form\Extension\Core\Type\DateType ;


class ConsulterController extends AbstractController
{
    public function index()
    {
		
		
		$form = $this->createFormBuilder(array())
					->add('Annee', 
					'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
					'choices' => $this->getYears(2000)])
					->add('Mois' ,
					'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
					'choices' => ['Janvier' => '01', 'Février' => '02', 'Mars' => '03', 'Avril' => '04' , 'Mai' => '05' , 'Juin' => '06', 'Juillet' => '07', 'Août' => '08', 'Septembre' => '09', 'Octobre' => '10', 'Novembre' => '11' , 'Décembre' => '12' ]])
					->add('Valider', SubmitType::class)
					->getForm();
					
		$request = Request::createFromGlobals() ;		
		$form->handleRequest( $request ) ;
		
		
					
		if($form->isSubmitted() && $form->isValid() ) {
			
			
			$data = $form->getData();
			$bd = new \PDO('mysql:host=localhost;dbname=GSB' , 'developpeur', 'azerty');
#			$sql = 
			
			
#			if($resultat->rowCount() == 1) {
				
#				$e = $resultat->fetch();
				
#				return $this->render('menu_v/index.html.twig' , [
#				'controller_name' => 'AccueilController',
#				]);

		}
				
				

			

						
		
        return $this->render('consulter/index.html.twig', [
            'formulaire' => $form->createView()

        ]);
        
	}
    
	
	
	public function getYears($min, $max='current')
	{
		
		$years = range($min, ($max === 'current' ? date('Y') : $max));
		return array_combine($years , $years);
		
		
		}
	
    
}
