<?php


namespace App\Controller;

use App\Entity\Form;
use App\Form\FormType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FormRepository;

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
    * @Route ("/contact", name = "contact")
     */
    public function contact (Request $request, FormRepository $formRepository, \Swift_Mailer $mailer) {

        $form = new Form();
        $form = $this->createForm(FormType::class, $form);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Votre demande a bien été envoyé.");
            $form->getData();

            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom($form ["email"])
                // On attribue le destinataire
                ->setTo('guillaume.gomez2@orange.fr')
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'Pages/contact.html.twig',
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);


            return $this->redirectToRoute('contact');
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