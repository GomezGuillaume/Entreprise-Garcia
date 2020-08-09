<?php


namespace App\Controller;

use App\Entity\Form;
use App\Form\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController {

    /**
     * @Route ("/", name = "Accueil")
     */
    public function Accueil () {

        return $this->render("Pages/page-accueil.html.twig");
    }

    /**
     * @Route ("/peintures", name = "Peintures")
     */
    public function Peintures () {

        return $this->render("Pages/interieur-exterieur.html.twig");
    }

    /**
     * @Route ("/toiture", name = "Toiture")
     */
    public function Toiture () {

        return $this->render('Pages/demoussage-toiture.html.twig');
    }

    /**
     * @Route ("/travaux", name = "Travaux")
     */
    public function Travaux () {

        return $this->render('Pages/travaux.html.twig');
    }

    /**
     * @Route ("/realisation", name = "Réalisations")
     */
    public function Réalisation () {

        return $this->render('Pages/mes-realisations.html.twig');
    }

    /**
     * @Route ("/contact", name = "Contact")
     */
    public function Contact (Request $request) {

        $form = new Form();
        $form = $this->createForm(FormType::class, $form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Votre demande a bien été envoyé.");
            return $this->redirectToRoute('Contact');
        }

        return $this->render('Pages/contact.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route ("/espace_utilisateur", name = "Connexion_Inscription")
     */
    public function espace_utilisateur () {

        return $this->render('Pages/connexion-inscription.html.twig');
    }


}