<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\VideoCategory;
use App\Form\VideoCategoryFormType;
use App\Form\VideoFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/videos", name="_videos")
     */
    public function videos(Request $request)
    {

        $videos =  $this->getDoctrine()->getRepository(Video::class)->findAll();

        $video = new Video();

        $form = $this->createForm(VideoFormType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Extracting the id of the video
            $url = $video->getUrl();
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            $youtubeId = $my_array_of_vars['v'];
            $video->setYoutubeId($youtubeId);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('admin_videos');
        }

        return $this->render('admin/videos.html.twig', [
            'form' => $form->createView(),
            'videos' => $videos,
        ]);
    }


    /**
     * @Route("/videos/{id}", name="_modify_video")
     */
    public function modifyVideo($id, Request $request)
    {

        $video = $this->getDoctrine()->getRepository(Video::class)->findOneBy([
            'id' => $id,
        ]);

        $form = $this->createForm(VideoFormType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $url = $video->getUrl();
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            $youtubeId = $my_array_of_vars['v'];
            $video->setYoutubeId($youtubeId);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('admin_videos');
        }

        return $this->render('admin/modify.html.twig', [
            'entityName' => 'vidéo',
            'cancelUrl' => $this->generateUrl('admin_videos'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie", name="_video_categories")
     */
    public function videoCategories(Request $request)
    {
        $categories =  $this->getDoctrine()->getRepository(VideoCategory::class)->findAll();

        $video_category = new VideoCategory();

        $form = $this->createForm(VideoCategoryFormType::class, $video_category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video_category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_video_categories');
        }

        return $this->render('admin/video_categories.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }
}
