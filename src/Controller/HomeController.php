<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of HomeController
 * @author linux
 */
class HomeController extends AbstractController{
    /**
     * 
     * @Route ("/", name="app_homepage")
     */
    public function homepage(){
        return $this->render("home/home.html.twig");
    }
}
