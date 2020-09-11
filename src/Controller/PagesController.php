<?php


namespace App\Controller;


use App\Repository\MediaRepository;
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
    public function Réalisation (MediaRepository $mediaRepository) {

        return $this->render('Pages/realisations.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/cgu-ml", name = "cgu-ml")
     */
    public function CguMl () {

        return $this->render("Pages/cgu-ml.html.twig");
    }

}