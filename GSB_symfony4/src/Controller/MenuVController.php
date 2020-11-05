<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MenuVController extends AbstractController
{
    public function index()
    {
		
		
		return $this->render('menu_v/index.html.twig' , [
				'controller_name' => 'AccueilController',
				]);

        
    }
}
