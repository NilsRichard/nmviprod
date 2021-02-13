<?php

namespace App\Controller;

use App\Entity\WebSiteContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends AbstractController
{
    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $info =  $this->getDoctrine()->getRepository(WebSiteContent::class)->findOneBy([]);
        if ($info == null) {
            $info = new WebSiteContent();
            $info->initializeDefault();
        }
        $parameters['info'] = $info;

        return parent::render($view, $parameters, $response);
    }
}
