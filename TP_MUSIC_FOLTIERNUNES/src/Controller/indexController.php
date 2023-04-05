<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Entity\Utilisateur;
use App\Repository\GenreRepository;
use App\Repository\AlbumRepository;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MusiqueRepository;



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
            if( $val->getMDP() == $query2){
                if( $val->getPseudo()== $query){
                    return $this->render('accueil.html.twig',[ 'log' => TRUE, 'pseudo' => $query ]);
                }
            }
        }


        return $this->render('connexion.html.twig');
    }

    /**
* @Route("/importer/{verif}")
*/
    public function importer($verif,GenreRepository $genreRepo,AlbumRepository $albumRepo,ArtisteRepository $artisteRepo,MusiqueRepository $musiqueRepo,EntityManagerInterface $entityManager){
        $output = new ConsoleOutput();
        if($verif=='TRUE'){
            $uploaddir = '../import/';
            $uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

            move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
            $json = file_get_contents("../import/".$_FILES['userfile']['full_path']);
            $BD = json_decode($json,TRUE);
            
            foreach($BD['BD'][0]['Genre'] as $elem){
                $genreRepo->insert($entityManager,$elem);
            }
            foreach($BD['BD'][0]['Album'] as $elem){
                $albumRepo->insert($entityManager,$elem['Titre'],$elem['Date'],$elem['URL']);

            }
            foreach($BD['BD'][0]['Artiste'] as $elem){
                $artisteRepo->insert($entityManager,$elem,'');

            }
            foreach($BD['BD'][0]['Musique'] as $elem){
                $musiqueRepo->insert($entityManager,$elem['Titre'],$elem['Date'],$elem['Album'],$elem['Artiste'],$elem['Genre']);

            }
            return $this->render('import.html.twig',['BD' => $BD]);
        }
        

        return $this->render('import.html.twig');
    }
}