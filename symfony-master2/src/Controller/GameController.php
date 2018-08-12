<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game")
     */
    public function index(Request $request, UserRepository $userRepository)
    {
    $user = new User();
    $users  = $userRepository->findAll();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
               }
    return $this->render('home/index.html.twig', array('form' => $form->createView(),'users'=>$users, ));
        }
}

