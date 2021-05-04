<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RenseignerController extends AbstractController
{
    public function index()
    {
        
        return $this->render('renseigner/index.html.twig', [
            'controller_name' => 'RenseignerController',
        ]);
    }
}
