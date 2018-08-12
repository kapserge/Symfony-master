<?php
namespace App\Manager;
use App\Entity\User;
use App\Form\LoginUserType;
use App\Form\RegisterUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserManager{

private $userRepository;
public function __construct(UserRepository $userRepository)   {
$this->userRepository = $userRepository;

   }
public function getUserByEmail(string $email): ?User{
return $this->userRepository->findOneBy(['email' => $email]);
   }
public function getUsersByFirstname(string $firstName): ?array
{
return $this->userRepository->findBy(['firstname' => $firstName], ['email' => 'ASC']);
   }

public function getCountArticleUser(UserRepository $userRepository)
{
$user = $userRepository->findAll();


   }
}