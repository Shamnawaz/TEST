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


class RenseignerffController extends AbstractController
{
    function index(Request $requete)
    {
        $today = getdate();
        $month = $today['mon'];
        $year = $today['year'];
        if(strlen($month) != 2){
            
            $month = 0 . $month;
        }
        
        $monthYear = sprintf("%02d%04d", $month , $year) ;
        
        echo "Renseigner ma fiche de frais du mois ".$month."-".$year ;
        
        $request = Request::createFromGlobals() ;
        $form = $this-> createFormBuilder()
                -> add('Forfait-Etape', TextType::class)
                /*-> add('Frais-Kilometrique', TextType::class) 
                -> add('Nuitee-Hotel', TextType::class)
                -> add('Repas-Restaurant', TextType::class)*/
                -> add('Valider', SubmitType::class)
                -> add('Effacer', ResetType::class)
                -> getForm() ;
       
        $form->handleRequest( $request );
        $session = $requete->getSession();
        
        if($form->isSubmitted() && $form->isValid() ) {
            
            $data = $form->getData();

            
            $bd = new \PDO('mysql:host=localhost;dbname=GSB' , 'developpeur' , 'azerty');
            $idV = $session->get('id');
            $resultat = $bd->prepare("select * from LigneFraisForfait where idVisiteur = :idV and mois = :mois and idFraisForfait = 'ETP'");
            $resultat->bindParam(':idV', $idV);
            
            var_dump($idV);
            
            $resultat->bindParam(':mois', $monthYear);
            $check = $resultat->fetch(\PDO::FETCH_ASSOC);
            $count = $resultat->rowCount();
            
            if($count == 0){
               
                
                $resultat1 = $bd->prepare("insert into LigneFraisForfait(idVisiteur, mois, idFraisForfait, quantite) values(:idV, :mois, 'ETP', :quantite)");
                $resultat1->bindParam(':idV', $idV);
                $resultat1->bindParam(':mois', $monthYear);
                $resultat1->bindParam(':quantite', $data['Forfait-Etape']);
                $resultat1-> execute();
                $b1 = $resultat1->fetch(\PDO::FETCH_ASSOC);
                
            }
            else{
                
                $sqlUp = $bd->prepare("update LigneFraisForfait set quantite = :quantite where idVisiteur = :idV and mois = :mois and idFraisForfait = 'ETP' ");
                $total = $data['Forfait-Etape'] + $check['quantite'];
                $sqlUp->bindParam(':quantite', $total);
                $sqlUp->bindParam(':idV', $idV);
                $sqlUp->bindParam(':mois', $monthYear);
                $sqlUp-> execute();
                
            }
                   
                
                
                
            
            
            
            /*$resultat2 = $bd->prepare('insert into LigneFraisForfait(idVisiteur, mois, idFraisForfait, quantite) values(:idV, :mois, KM, :quantite)');
            $resultat2-> bindParam(':idV', $idV);
            $resultat2-> bindParam(':mois', $monthYear);
            $resultat2-> bindParam(':quantite', $data['Frais-Kilometrique']);
            $b2 = $resultat2->fetch(\PDO::FETCH_ASSOC);
            
            $resultat3 = $bd->prepare('insert into LigneFraisForfait(idVisiteur, mois, idFraisForfait, quantite) values(:idV, :mois, NUI, :quantite)');
            $resultat3-> bindParam(':idV', $idV);
            $resultat3-> bindParam(':mois', $monthYear);
            $resultat3-> bindParam(':quantite', $data['Nuitee-Hotel']);
            $b3 = $resultat3->fetch(\PDO::FETCH_ASSOC);
            
            $resultat4 = $bd->prepare('insert into LigneFraisForfait(idVisiteur, mois, idFraisForfait, quantite) values(:idV, :mois, REP, :quantite)');
            $resultat4-> bindParam(':idV', $idV);
            $resultat4-> bindParam(':mois', $monthYear);
            $resultat4-> bindParam(':quantite', $data['Repas-Restaurant']);
            $b4 = $resultat4->fetch(\PDO::FETCH_ASSOC); */
            
            
                
            
            /*$resultat2-> execute();
            $resultat3-> execute();
            $resultat4-> execute();*/
            
            
            /*echo var_dump($form-> getExtraData());*/
           
           
           return $this->render('renseigner/index.html.twig', [
            'controller_name' => 'RenseignerController', 'formulaire' => 
               $form->createView(),
        ]);
            
            
        }
        
        
        
        return $this->render('renseignerff/index.html.twig', [
            'controller_name' => 'RenseignerffController', 'formulaire' => 
               $form->createView(),
        ]);
    }
}
