<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use App\Form\RegisterUserType;
use App\Form\LoginUserType;
use App\Form\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
class SecurityController extends Controller
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
	   /**
		* @Route("/register", name="register")
		*/
	public function register(Request $request , UserPasswordEncoderInterface $passwordEncoder )
		{
		$user = new User();
		$form = $this->createForm(RegisterUserType:: class, $user);
		$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				$password = $passwordEncoder ->encodePassword( $user, $user->getPassword());
				$user->setPassword( $password );
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager ->persist( $user);
				$entityManager ->flush();
			return $this->redirectToRoute( 'home');
			}
		return $this->render( 'security/register.html.twig', [
		'form' => $form->createView()
		]);
		}
		/**
		* @Route("/login", name="login")
		*/
		public function login(AuthenticationUtils $authenticationUtils ){
			$user = new User();
			$form = $this->createForm(LoginUserType:: class, $user);
			return $this->render( 'security/login.html.twig', ['error' => $authenticationUtils ->getLastAuthenticationError(),
			'form' => $form->createView()]);
		}
		/**
		* @Route("/profile", name="profile")
		*/
		public function profil(Request $request , EntityManagerInterface $entityManager )
			{
			$user = $this->getUser();
			$form = $this->createForm(ProfileType:: class, $user);
			$form->handleRequest( $request );
					
			return $this->render( 'security/profile.html.twig', [
			'form' => $form->createView()
			]);
			}
}
