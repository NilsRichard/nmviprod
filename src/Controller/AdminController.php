<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\VideoCategory;
use App\Entity\WebSiteContent;
use App\Form\VideoCategoryFormType;
use App\Form\VideoFormType;
use App\Form\WebSiteContentFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    public function renderWithContent(string $view, array $parameters = [])
    {
        $info =  $this->getDoctrine()->getRepository(WebSiteContent::class)->findOneBy([]);
        if($info == null){
            $info = new WebSiteContent();
            $info->initializeDefault();
        }

        $parameters['info'] = $info;
        
        return $this->render($view, $parameters);
    }

    /**
     * @Route("/videos", name="videos")
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

        return $this->renderWithContent('admin/videos.html.twig', [
            'form' => $form->createView(),
            'videos' => $videos,
        ]);
    }


    /**
     * @Route("/videos/{id}", name="modify_video")
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

        return $this->renderWithContent('admin/modify.html.twig', [
            'entityName' => 'vidéo',
            'cancelUrl' => $this->generateUrl('admin_videos'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/videos/remove/{id}", name="remove_video")
     */
    public function removeVideo($id)
    {
        $video = $this->getDoctrine()->getRepository(Video::class)->findOneBy([
            'id' => $id,
        ]);

        $em = $this->getDoctrine()->getManager();

        $em->remove($video);
        $em->flush();

        return $this->redirectToRoute('admin_videos');
    }

    /**
     * @Route("/categories", name="video_categories")
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

        return $this->renderWithContent('admin/video_categories.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categories/{id}", name="modify_video_category")
     */
    public function modifyVideoCategories($id,Request $request)
    {
        $video_category = $this->getDoctrine()->getRepository(VideoCategory::class)->findOneBy([
            'id' => $id,
        ]);

        $form = $this->createForm(VideoCategoryFormType::class, $video_category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video_category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_video_categories');
        }

        return $this->renderWithContent('admin/modify.html.twig', [
            'entityName' => 'catégorie',
            'form' => $form->createView(),
            'cancelUrl' => $this->generateUrl('admin_video_categories'),
        ]);
    }

     /**
     * @Route("/category/remove/{id}", name="remove_video_category")
     */
    public function removeVideoCategory($id)
    {
        $video_category = $this->getDoctrine()->getRepository(VideoCategory::class)->findOneBy([
            'id' => $id,
        ]);

        if($video_category->getVideos()->isEmpty()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $em->remove($video_category);
            $em->flush();
        }

        return $this->redirectToRoute('admin_video_categories');
    }



    /**
     * @Route("/information", name="modify_information")
     */
    public function modifyInformation(Request $request)
    {
        $information = $this->getDoctrine()->getRepository(WebSiteContent::class)->findOneBy([]);

        if($information == null) $information = new WebSiteContent();

        $form = $this->createForm(WebSiteContentFormType::class, $information);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($information);
            $entityManager->flush();

            return $this->redirectToRoute('admin_modify_information');
        }

        return $this->renderWithContent('admin/modify.html.twig', [
            'entityName' => 'information',
            'form' => $form->createView(),
        ]);
    }
}
