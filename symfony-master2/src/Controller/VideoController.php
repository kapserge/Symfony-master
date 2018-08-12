<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class VideoController extends Controller
{
    /**
     * @Route("/", name="video")
     */
    public function index(Request $request, VideoRepository $videoRepository)
    {

        $video = new Video();
        

        $videos = $videoRepository->findAll();

        return $this->render('video/index.html.twig', array(

           'video'=>$videos
            
        )
        );
    }
     /**
     * @Route("/video/remove/{id}", name="video_remove")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */

    public function remove(Video $video, EntityManagerInterface $entityManager){

        $entityManager->remove($video);
        $entityManager->flush();
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/video/{id}", name="video_detail")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */

    public function detailVideo($id){

        //$video = new Video();
        //$videos = $videoRepository->findAll();
        $videos = $this->getDoctrine()->getRepository(Video::class)->find($id);

         if (!$videos) {
        throw $this->createNotFoundException('No video found for id '.$id);
    }

    
        return $this->render('video/index_detail.html.twig', array(

           'video'=>$videos
            
        )
        );

    }
}
