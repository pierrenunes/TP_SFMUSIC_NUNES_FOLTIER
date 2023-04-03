<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UtilisateurRepository;
class indexController extends AbstractController{

/**
* @Route("/")
*/
    public function open(){
        return $this->render('accueil.html.twig');
    }

/**
* @Route("/test")
*/
    public function drole(UtilisateurRepository $utilisateurs){
        return $this->render('test.html.twig', [
            'utilisateur' => $utilisateurs->findAll()
        ]);
    }
}