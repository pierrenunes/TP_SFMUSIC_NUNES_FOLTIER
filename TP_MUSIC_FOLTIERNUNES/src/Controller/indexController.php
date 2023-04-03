<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;



class indexController extends AbstractController{

/**
* @Route("/")
*/
    public function open(){
        return $this->render('accueil.html.twig',[ 'log' => FALSE, 'pseudo' => '']);
    }

/**
* @Route("/test")
*/
    public function drole(UtilisateurRepository $utilisateurs){
        return $this->render('test.html.twig', [
            'utilisateur' => $utilisateurs->findAll()
        ]);
    }

    /**
* @Route("/connexion")
*/
    public function connexion(Request $request,UtilisateurRepository $utilisateurs,EntityManagerInterface $entity){
        $query = $request->query->get('prenom_nom_util');
        $query2 = $request->query->get('mdp_util');
        $user = $utilisateurs->findAll();
        
        $output = new ConsoleOutput();
        $output->writeln($user);
        foreach( $user as &$val ){
            $output->writeln('--------------------------------------');
            $output->writeln($val);
            if( $val->getMDP() == $query2){
                if( $val->getPseudo()== $query){
                    return $this->render('accueil.html.twig',[ 'log' => TRUE, 'pseudo' => $query ]);
                }
            }
        }


        return $this->render('connexion.html.twig');
    }
}