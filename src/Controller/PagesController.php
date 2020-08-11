<?php


namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PagesController extends AbstractController {

    /**
     * @Route ("/", name = "accueil")
     */
    public function Accueil () {

        return $this->render("Pages/page-accueil.html.twig");
    }

    /**
     * @Route ("/peintures", name = "peintures")
     */
    public function Peintures () {

        return $this->render("Pages/interieur-exterieur.html.twig");
    }


    /**
     * @Route ("/travaux", name = "travaux")
     */
    public function Travaux () {

        return $this->render('Pages/travaux.html.twig');
    }

    /**
     * @Route ("/realisation", name = "realisations")
     */
    public function Réalisation () {

        return $this->render('Pages/mes-realisations.html.twig');
    }




}