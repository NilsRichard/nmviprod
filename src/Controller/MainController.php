<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\VideoCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/portfolio/{id}", name="portfolio" , defaults={"id"=-1})
     */
    public function portfolio($id)
    {

        $selectedCategory = null;
        if ($id != -1) {
            $selectedCategory =  $this->getDoctrine()->getRepository(VideoCategory::class)->findOneBy([
                'id' => $id,
            ]);
        }
        $categories = $this->getDoctrine()->getRepository(VideoCategory::class)->findAll();

        return $this->render('main/portfolio.html.twig', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * @Route("/portfolio/video/{id}", name="portfolio_video" , defaults={"id"=-1})
     */
    public function portfolioVideo($id)
    {

        $selectedVideo =  $this->getDoctrine()->getRepository(Video::class)->findOneBy([
            'id' => $id,
        ]);

        if($selectedVideo == null)  throw $this->createNotFoundException('La video n\'existe pas');

        return $this->render('main/portfolio_video.html.twig', [
            'selectedVideo' => $selectedVideo,
        ]);
    }

    /**
     * @Route("/location", name="location")
     */
    public function location()
    {
        return $this->render('main/location.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/services", name="services")
     */
    public function services()
    {
        return $this->render('main/services.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/projectupo", name="projectupo")
     */
    public function projectupo()
    {
        return $this->render('main/project_upo.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projectupouvp", name="projectupouvp")
     */
    public function projectupouvp()
    {
        return $this->render('main/project_upo_uvp.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
