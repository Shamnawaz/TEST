<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request ;


class MenuVController extends AbstractController
{
    public function index(Request $requete)
    {
		$session = $requete->getSession();
                $prenomV = $session->get('prenom');
                $nomV = $session->get('id');
                $idV = $session->get('login');
                
                $info = ['prenomV' => $prenomV, 'nomV' => $nomV, 'idVisiteur' => $idV];
                
		
		return $this->render('menu_v/index.html.twig' , [
				'controller_name' => 'AccueilController', 
				]);

        
    }
}
