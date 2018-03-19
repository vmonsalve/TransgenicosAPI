<?php

namespace Tiempo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TiempoApiBundle:Default:index.html.twig');
    }
}
