<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileUserType;
use App\Form\UserType;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $games = $userRepository->findAll();

        return $this->render('security/admin.html.twig', array(

                'form'=>$form->createView(),
                
                'games'=>$games
            )

        );
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user, VideoRepository $videoRepository){
        $entityManager = $this->getDoctrine()->getManager();
        $video = new Video();
        

        $form = $this->createForm(VideoType::class,$video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){   
            $video->setUser($user);
            $entityManager->persist($video);
            $entityManager->flush();
        }
        return $this->render('user/user.html.twig',['form'=>$form->createView(),
                'user'=> $user,
        ]

        );

    }


    /**
     * @Route("/profile", name="profile")
     */

    public function profile(Request $request, EntityManagerInterface $entityManager){

        $user = $this->getUser();
        $form =$this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('security/profile.html.twig',[
            'form' => $form->createView()
        ]);

    }

    
}
