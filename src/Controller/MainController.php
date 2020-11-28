<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\VideoCategory;
use App\Entity\WebSiteContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
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
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->renderWithContent('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->renderWithContent('main/about.html.twig', [
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

        return $this->renderWithContent('main/portfolio.html.twig', [
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

        if ($selectedVideo == null)  throw $this->createNotFoundException('La video n\'existe pas');

        return $this->renderWithContent('main/portfolio_video.html.twig', [
            'selectedVideo' => $selectedVideo,
        ]);
    }

    /**
     * @Route("/location", name="location")
     */
    public function location()
    {
        return $this->renderWithContent('main/location.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->renderWithContent('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/services", name="services")
     */
    public function services()
    {
        return $this->renderWithContent('main/services.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/projectupo", name="projectupo")
     */
    public function projectupo()
    {
        return $this->renderWithContent('main/project_upo.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projectupouvp", name="projectupouvp")
     */
    public function projectupouvp()
    {
        return $this->renderWithContent('main/project_upo_uvp.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
