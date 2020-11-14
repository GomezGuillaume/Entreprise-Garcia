<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //ici on envoie le mail
            $message = (new \Swift_Message("Nouveau contact"))

                //on attribut l'expéditeur
                ->setFrom($contact ["email"])

                //on attribut le destinataire
                ->setTo("contact@entreprise-garcia.com")

                ->setBody(
                    $this->renderView("emails/email.html.twig", compact("contact")),

                    "text/html"
            );

                //on envoie le message
                $mailer->send($message);
                $this->addFlash("message", "Votre message a bien été envoyé");

                return $this->redirectToRoute('contact');

        }

        return $this->render("Pages/contact.html.twig", [
            'contactForm' => $form->createView()
        ]);
    }
}
