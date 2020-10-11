<?php

namespace App\Controller;

use App\Entity\VideoCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
