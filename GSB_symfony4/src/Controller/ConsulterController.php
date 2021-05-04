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
    public function index(Request $requete)
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
		$session = $requete->getSession();
                $erreur = "Il n'y a pas de fiche de frais à cette date";
               
		
					
		if($form->isSubmitted() && $form->isValid() ) {
			
			
			$data = $form->getData();
			$bd = new \PDO('mysql:host=localhost;dbname=GSB' , 'developpeur', 'azerty');
                        $comb = sprintf("%02d%04d",$data['Mois'],$data['Annee']) ;
                        $id = $session->get('id');
                        $resultat = $bd-> prepare('select e.id, 
                            e.libelle , 
                            f.dateModif,
                            l.quantite, 
                            LigneFraisHorsForfait.montant, 
                            LigneFraisHorsForfait.libelle, 
                            LigneFraisHorsForfait.date 
                            from FicheFrais as f inner join Etat as e 
                            on f.idEtat = e.id  
                            inner join LigneFraisForfait as l on f.idVisiteur = l.idVisiteur 
                            inner join LigneFraisHorsForfait on f.idVisiteur = LigneFraisHorsForfait.idVisiteur 
                            where f.mois = :mois');
                        
                        $resultat->bindParam(':mois' , $comb);
#                        $resultat-> bindParam(':idVisiteur' , $id);
                        $resultat->execute();
                        $b1 = $resultat->fetch(\PDO::FETCH_ASSOC);
                        
                        
                        
                        
                        
                        
                        return $this->render('consulter/index2.html.twig', [
                        'formulaire' => $form->createView() , 'b1' => $b1,
                        
                          ]);
                     
                
                }
                

			

		return $this->render('consulter/index.html.twig', [
                        'formulaire' => $form->createView(),
                          ]);				
		
     
        
	}
        
        
    
	
	
	public function getYears($min, $max='current')
	{
		
		$years = range($min, ($max === 'current' ? date('Y') : $max));
		return array_combine($years , $years);
		
		
		}
	
    
}
