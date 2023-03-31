<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class indexController extends AbstractController{

/**
* @Route("/")
*/
    public function open(){
        return $this->render('accueil.html.twig');
    }

    public function drole(){
        return $this->render('drole.html.twig');
    }
}