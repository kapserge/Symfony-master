<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserRepository $userRepository){
    //$user = new User();
    $users  = $userRepository->findAll();
    //$article  = $userRepository->findAll();
            
    return $this->render('home/index.html.twig', array('users'=>$users, ));
        }
}
