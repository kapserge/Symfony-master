<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
     public function index(Request $request,  ArticleRepository $ArticleRepository)
    {
    $article = new Article();
    $article  = $userRepository->findAll();
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($article);
                    $entityManager->flush();
               }
    return $this->render('article/index.html.twig', array('form' => $form->createView(), ));
        }
     /**
      * @Route("/article/remove/{id}", name="article_remove")
      * @ParamConverter("user", options={"mapping"={"id"="id"}})
      */
    public function remove(Article $article , EntityManagerInterface $entityManager )
        {
        $entityManager ->remove( $article );
        $entityManager ->flush();
        return $this->redirectToRoute( 'home');
        }
}
